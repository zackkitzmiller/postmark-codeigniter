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

