<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*
|--------------------------------------------------------------------------
| POSTMARK API KEY
|--------------------------------------------------------------------------
|
| Enter your Postmark API key here.
|
| This key is available by visiting your Postmark Rack, clicking 'Details'
| next to the desiered server, then clicking 'Settings & API Credentials'
|
*/
$config['api_key'] = '';
 
/*
|--------------------------------------------------------------------------
| FROM NAME & FROM ADDRESS
|--------------------------------------------------------------------------
|
| These are optional settings
|
| If you're going to be using the same Sender Signature for all emails, it
| might be easier to assign it here, than doing so with each individual
| email. If you are not using this setting, comment it out.
|
| Configure your Sender Signatures at http://postmarkapp.com/signatures
*/
$config['from_name'] = '';
$config['from_address'] = '';
 
/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
|
| Setting validation to TRUE will require that you pass Postmark valid
| email addresses for sender and reciever. If these are not valid email
| addresses, the request to send an email will not be sent to Postmark.
|
| This is reccomended on high traffic servers
|
*/
$config['validation'] = TRUE;
 
/*
|--------------------------------------------------------------------------
| STRIP_HTML
|--------------------------------------------------------------------------
|
| Setting strip_tags to TRUE will strip all HTML tags from _plain_message
| using PHP's strip_tags() function. It should be noted that the output
| will probably be far from what you would expect.
|
| Experimental Feature
|
*/
$config['strip_html'] = TRUE;
 
/*
|--------------------------------------------------------------------------
| DEVELOP
|--------------------------------------------------------------------------
|
| Often when implementing your client library or when integrating an
| existing library into your application you would want to send 'test'
| emails that don't actually get delivered to the recipient. You just need
| to know if your data is valid. You can do that by setting this to TRUE
|
*/
$config['develop'] = FALSE;