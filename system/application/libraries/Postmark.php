<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Postmark Email Library
 *
 * Permits email to be sent using Postmarkapp.com's Servers
 *
 * @category	Libraries
 * @author		Based on work by János Rusiczki & Markus Hedlund’s.
 * @modified    Heavily Modified by Zack Kitzmiller
 * @link		http://www.github.com/zackkitzmiller/postmark-codeigniter
*/

class Postmark {

	//private
	var $CI;
        var $api_key = '';
    	
	var $from_name;
	var $from_address;
	
	var $_toName;
	var $_toAddress;
	var $_subject;
	var $_messagePlain;
	var $_messageHtml;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */	
         function Postmark($params = array())
         {
             $this->CI =& get_instance();
        
             if (count($params) > 0)
             {
                 $this->initialize($params);
             }
		
             log_message('debug', 'Postmark Class Initialized');

	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */	
         function initialize($params)
         {
             $this->clear();
             if (count($params) > 0)
             {
                 foreach ($params as $key => $value)
                 {
                     if (isset($this->$key))
                     {
                         $this->$key = $value;
                     }
                 }
             }
         }

	// --------------------------------------------------------------------

	/**
	 * Clear the Email Data
	 *
	 * @access	public
	 * @return	void
	 */	
         function clear() {
             $this->from_name = '';
    	     $this->from_address = '';
    	     $this->_toName = '';
    	     $this->_toAddress = '';
    	     $this->_subject = '';
    	     $this->_messagePlain = '';
    	     $this->_messageHtml = '';	
        }
	
	// --------------------------------------------------------------------

	/**
	 * Set Email FROM address
	 *
	 * This could also be set in the config file
	 *
	 * TODO:
	 * Validate Email Addresses ala CodeIgniter's Email Class
	 *
	 * @access	public
	 * @return	void
	 */	
	function from($address, $name = null)
	{
		$this->from_address = $address;
		$this->from_name = $name;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Email TO address
	 *
	 * TODO:
	 * Validate Email Addresses ala CodeIgniter's Email Class
	 *
	 * @access	public
	 * @return	void
	 */	
	function to($address, $name = null)
	{
		$this->_toAddress = $address;
		$this->_toName = $name;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Email Subject
	 *
	 * @access	public
	 * @return	void
	 */	
	function subject($subject)
	{
		$this->_subject = $subject;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Email Message in Plain Text
	 *
	 * @access	public
	 * @return	void
	 */	
	function messagePlain($message)
	{
		$this->_messagePlain = $message;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Email Message in HTML
	 *
	 * @access	public
	 * @return	void
	 */	
	function messageHtml($message)
	{
		$this->_messageHtml = $message;
	}

	// --------------------------------------------------------------------
    /**
    * Private Function to prepare and send email
    */
	function _prepareData()
	{
		$data = array(
			'Subject' => $this->_subject
		);
		
		$data['From'] = is_null($this->from_name) ? $this->from_address : "{$this->from_name} <{$this->from_address}>";
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
	
		if (is_null($this->api_key)) {
			show_error("Postmark API key is not set!");
		}
		
		if (is_null($this->from_address)) {
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
	
		$encoded_data = json_encode($this->_prepareData());
		
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . $this->api_key
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$return = curl_exec($ch);
		log_message('debug', 'JSON: ' . $encoded_data . "\nHeaders: \n\t" . implode("\n\t", $headers) . "\nReturn:\n$return");
		
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