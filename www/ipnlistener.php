<?php

/*

	Paypal IPN Listener example

*/


require 'IPN.php';
$ipn = new IPN;

// the paypal url, or the sandbox url, or the ipn test url
$ipn->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

// your paypal email (the one that receives the payments)
$ipn->paypal_email = 'natalie@cantabilemusic.com.au';

// log to file options
$ipn->log_to_file = fales;					// write logs to file
$ipn->log_filename = '/var/log/ipn.log';  	// the log filename (should NOT be web accessible and should be writable)

// log to e-mail options
$ipn->log_to_email = true;					// send logs by e-mail
$ipn->log_email = 'ben@playedinane.com';		// where you want to receive the logs
$ipn->log_subject = 'IPN Log: ';			// prefix for the e-mail subject

// database information
$ipn->log_to_db = false;						// false not recommended
$ipn->db_host = 'localhost';				// database host
$ipn->db_user = 'cantabilemusic';				// database user
$ipn->db_pass = 'claire';			// database password
$ipn->db_name = 'cantabilemusic';						// database name

// array of currencies accepted or false to disable
$ipn->currencies = array('AUS');

// date format on log headers (default: dd/mm/YYYY HH:mm:ss)
// see http://php.net/date
$ipn->date_format = 'd/m/Y H:i:s';

// Prefix for file and mail logs
$ipn->pretty_ipn = "IPN Values received:\n\n";
$ipn->write_log('Start',"start");


// configuration ended, do the actual check

if($ipn->ipn_is_valid()) {
	/*
		A valid ipn was received and passed preliminary validations
		You can now do any custom validations you wish to ensure the payment was correct
		You can access the IPN data with $ipn->ipn['value']
		The complete() method below logs the valid IPN to the places you choose
	*/
	$ipn->complete();
}

?>