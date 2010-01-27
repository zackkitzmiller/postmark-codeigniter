<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	CodeIgniter Postmark Library
	
	Postmark
	http://postmarkapp.com
	
	Based on Markus Hedlund's Postmark class for PHP
	http://github.com/Znarkus/postmark-php/blob/master/Postmark.php
	
	Requires PHP 5.2.0 or higher.
	
	Usage guide:
	
	$this->load->library('postmark');
	$this->postmark->from('from@example.com', 'From Name');
	$this->postmark->to('to@example.com', 'To Name);
	$this->postmark->subject('Example subject');
	$this->postmark->messagePlain('Testing...');
	$this->postmark->messageHtml('<html><strong>Testing...</strong></html>');
	$this->postmark->send();
	
	OR
	
	$this->load->library('postmark');
	$this->postmark->send('from@example.com', 'From Name', 'to@example.com', 'To Name', 'Example Subject', 'Testing...', '<html><strong>Testing...</strong></html>');
	
	If you need to send the same e-mail to several recipients you can just change the to fields
	with to() and then use send() to send the e-mail. This works for any field.

	If you need to reset all the fields to null use new_email().
*/

class Postmark {

	var $_rConfig;
	var $_ci;
	
	var $_fromName;
	var $_fromAddress;
	var $_toName;
	var $_toAddress;
	var $_subject;
	var $_messagePlain;
	var $_messageHtml;

	
	function __construct()
	{
		log_message('debug', 'Postmark class Initialized');
		$this->_ci =& get_instance();
		$this->_ci->config->load('postmark');
		$this->_rConfig = $this->_ci->config->item('postmark');
		
		$this->to(null, null);
		$this->from(null, null);
		$this->messagePlain(null);
		$this->messageHtml(null);
	}
	
	function new_email()
	{
		$this->to(null, null);
		$this->from(null, null);
		$this->messagePlain(null);
		$this->messageHtml(null);
	}
	
	/**
	* Specify sender. Overwrites default From.
	*/
	function from($address, $name = null)
	{
		$this->_fromAddress = $address;
		$this->_fromName = $name;
	}
	
	/**
	* Specify receiver
	*/
	function to($address, $name = null)
	{
		$this->_toAddress = $address;
		$this->_toName = $name;
	}
	
	/**
	* Specify subject
	*/
	function subject($subject)
	{
		$this->_subject = $subject;
	}
	
	/**
	* Add plaintext message. Can be used in conjunction with messageHtml()
	*/
	function messagePlain($message)
	{
		$this->_messagePlain = $message;
	}
	
	/**
	* Add HTML message. Can be used in conjunction with messagePlain()
	*/
	function messageHtml($message)
	{
		$this->_messageHtml = $message;
	}

	
	function _prepareData()
	{
		$data = array(
			'Subject' => $this->_subject
		);
		
		$data['From'] = is_null($this->_fromName) ? $this->_fromAddress : "{$this->_fromName} <{$this->_fromAddress}>";
		$data['To'] = is_null($this->_toName) ? $this->_toAddress : "{$this->_toName} <{$this->_toAddress}>";
		
		if (!is_null($this->_messageHtml)) {
			$data['HtmlBody'] = $this->_messageHtml;
		}
		
		if (!is_null($this->_messagePlain)) {
			$data['TextBody'] = $this->_messagePlain;
		}
		
		return $data;
	}
	
	public function send($from_address = null, $from_name = null, $to_address = null, $to_name = null, $subject = null, $message_plain = null, $message_html = null)
	{
	
		if (!is_null($from_address)) $this->from($from_address, $from_name);
		if (!is_null($to_address)) $this->to($to_address, $to_name);
		if (!is_null($subject)) $this->subject($subject);
		if (!is_null($message_plain)) $this->messagePlain($message_plain);
		if (!is_null($message_html)) $this->messageHtml($message_html);
	
		if (is_null($this->_rConfig['api_key'])) {
			show_error("Postmark API key is not set!");
		}
		
		if (is_null($this->_fromAddress)) {
			show_error("From address is not set!");
		}
		
		if (is_null($this->_toAddress)) {
			show_error("To address is not set!");
		}
		
		if (is_null($this->_subject)) {
			show_error("Subject is not set!");
		}
		
		if (is_null($this->_messagePlain) && is_null($this->_messageHtml)) {
			show_error("Please either set plain message, HTML message or both!");
		}
	
		$data = $this->_prepareData();
		
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . $this->_rConfig['api_key']
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$return = curl_exec($ch);
		log_message('debug', 'JSON: ' . json_encode($data) . "\nHeaders: \n\t" . implode("\n\t", $headers) . "\nReturn:\n$return");
		
		if (curl_error($ch) != '') {
			show_error(curl_error($ch));
		}
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if (intval($httpCode / 100) != 2) {
			$message = json_decode($return)->Message;
			show_error('Error while mailing. Postmark returned HTTP code ' . $httpCode . ' with message "'.$message.'"');
		}
	}
}

?>