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
| email. 
|
| Configure your Sender Signatures at http://postmarkapp.com/signatures
*/
$config['from_name'] = '';
$config['from_address'] = '';

