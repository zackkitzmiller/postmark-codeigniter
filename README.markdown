CodeIgniter Postmark Library
	
Postmark
http://postmarkapp.com

Created by János Rusiczki - http://www.rusiczki.net

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

CodeIgniter-Postmark
=========================

This Library is based heavily on János Rusiczki's (http://www.rusiczki.net) CodeIgniter Postmark Library, which is based on Based on Markus Hedlund's Postmark class for PHP. 

I spent a bit of time making this library resemble the internal CodeIgniter libraries a little more.

Installation
------------

Copy system/application/config/postmark.php to your application/config folder
Copy system/application/libraries/Postmark.php to your application/libraries folder

Usage
------

Config
	
	There are three options that you can set in the config file (application/config/postmark.php)
	Only api-key is required, which you get from your server instance on postmarkapp.com
	
	The other two are optional 'From Name' and 'From Address'. This are setup in your postmarkapp.com sender signatures.
	
	You can also pass an array of config options to the initialize(); function. 
	
	$config['api_key'] = '1234';
	$config['from_address'] = '1f@google.com';
	$config['from_name'] = 'Jarrod HJena3';
	$this->postmark->initialize($config);

Sending

    $this->load->library('postmark');
	// option, you can set these in config/postmark.php
    $this->postmark->from('from@example.com', 'From Name');

    $this->postmark->to('to@example.com', 'To Name);
    $this->postmark->subject('Example subject');
    $this->postmark->messagePlain('Testing...');
    $this->postmark->messageHtml('<html><strong>Testing...</strong></html>');
    $this->postmark->send();
	
If using this in a loop, calling $this->postmark->to('to'); again will *replace* the original recipient, and calling $this->postmark->clear(); will set all fields to null. 

Extra
-----

If you'd like to request changes, report bug fixes, or contact
the developer of this library, email <email@philsturgeon.co.uk>
