CodeIgniter-Postmark
=========================

I spent a bit of time making this library resemble the internal CodeIgniter libraries a little more.

Installation
------------

1.  Copy system/application/config/postmark.php to your application/config folder
2.  Copy system/application/libraries/Postmark.php to your application/libraries folder

Usage
------

### Config

There are six options that you can set in the config file (application/config/postmark.php)
Only api-key is required, which you get from your server instance on postmarkapp.com

The other five are optional. You can set a default 'From Name' and 'From Address'. This are setup in your postmarkapp.com sender signatures.

Setting 'validation' to TRUE will require that the to and from email addresses are, indeed, valid emails. A request will not be sent to
postmarkapp.com if either of these are not a valid email address, saving bandwitdh.

Setting 'strip_html' to TRUE will simply remove all HTML tags from the non-HTML message that gets sent to your recipient. Some wild and crazy
formatting things will happen if you set this to TRUE, but the email will send, and not fail.

Setting 'develop' to TRUE will use the generic POSTMARK_API_TEST token to make sure that your configuration is correct. And email will _*not*_
be sent.

You can also pass an array of config options to the initialize(); function.

	$config['api_key'] = '1234';
	$config['from_address'] = '1f@gogle.com';
	$config['from_name'] = 'Jarrod HJena3';

	$config['validation'] = TRUE;
	$config['strip_html'] = TRUE;
	$config['develop'] = FALSE;

	$this->postmark->initialize($config);

### Sending

    $this->load->library('postmark');
	// option, you can set these in config/postmark.php
    $this->postmark->from('from@example.com', 'From Name');

    $this->postmark->to('to@example.com', 'To Name');

    $this->postmark->cc('cc@example.com', 'Cc Name');
    $this->postmark->bcc('bcc@example.com', 'BCC Name');
		$this->postmark->reply_to('us@us.com', 'Reply To');

    // optional
    $this->postmark->tag('Some Tag');

    $this->postmark->subject('Example subject');
    $this->postmark->message_plain('Testing...');
    $this->postmark->message_html('<html><strong>Testing...</strong></html>');

    // add attachments (optional)
    $this->postmark->attach(PATH TO FILE);
    $this->postmark->attach(PATH TO OTHER FILE);

    // add headers (optional)
    $this->postmark->header('Name', 'Value');

    // send the email
    $this->postmark->send();

### Sending with the Postmark Templating engine

If you have configured templates in the postmark templating engine in your account, you can set options here.
https://postmarkapp.com/developer/api/templates-api#email-with-template

		// Set the template id
		$this->postmark->template_id(123456);

		// Optional: Add items to the template model
		$this->postmark->template_model('key', 'value');
		$this->postmark->template_model('key2', 'value2');
		$this->postmark->template_model('key3', 'value3');
		$this->postmark->template_model('key4', array('one', 'two', 'three'));

If you set a template_id, any values set for subject, message_plain, or message_html will be completely ignored.


If using this in a loop, calling $this->postmark->to('to'); again will *replace* the original recipient, and calling $this->postmark->clear(); will set all fields to null.
Postmark has now added the ability to send to multiple recipients. This is done by passing a comma separated string to $this->postmark->to();

$this->postmark->to('ex1@g.com, ex3@g.com');

ChangeLog
---------
* 1.3 - Added support for ReplyTo
* 1.4 - Attachments
* 1.5 - Added support for BCC
* 1.6 - Added support for Headers

License
-------
DON'T BE A DICK PUBLIC LICENSE

                    Version 1, December 2009

 Copyright (C) 2009 Philip Sturgeon <email@philsturgeon.co.uk>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

                  DON'T BE A DICK PUBLIC LICENSE
    TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  1. Do whatever you like with the original work, just don't be a dick.

     Being a dick includes - but is not limited to - the following instances:

 1a. Outright copyright infringement - Don't just copy this and change the name.
 1b. Selling the unmodified original with no work done what-so-ever, that's REALLY being a dick.
 1c. Modifying the original work to contain hidden harmful content. That would make you a PROPER dick.

  2. If you become rich through modifications, related works/services, or supporting the original work,
 share the love. Only a dick would make loads off this work and not buy the original works
 creator(s) a pint.

  3. Code is provided with no warranty. Using somebody else's code and bitching when it goes wrong makes
 you a DONKEY dick. Fix the problem yourself. A non-dick would submit the fix back.

Extra
-----

If you'd like to request changes, report bug fixes, or contact
the developer of this library, email <zack@inrpce.com>
