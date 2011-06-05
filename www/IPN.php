<?php
/**
 * Paypal IPN class
 * v1.0 (27/05/2008)
 * Copyright 2008 Roberto Gomes
 * http://ptdev.net
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class IPN {

	// Official url: https://www.paypal.com/cgi-bin/webscr
	// Testing urls: (do test!)
	//  - https://www.sandbox.paypal.com/cgi-bin/webscr
	//  - http://www.eliteweaver.co.uk/testing/ipntest.php
	public $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

	// your paypal email (the one that receives the payments)
	public $paypal_email = 'paypal@example.com';

	// log to file options
	public $log_to_file = true;					// write logs to file
	public $log_filename = '/path/to/ipn.log';  // the log filename (should NOT be web accessible)

	// log to e-mail options
	public $log_to_email = true;				// send logs by e-mail
	public $log_email = 'log@example.com';		// where you want to receive the logs
	public $log_subject = 'IPN Log: ';			// prefix for the e-mail subject

	// database information
	public $log_to_db = true;					// false not recommended
	public $db_host = 'localhost';
	public $db_user = 'some_user';
	public $db_pass = 'some_password';
	public $db_name = 'ipn';

	// array of currencies accepted or false to disable
	public $currencies = array('USD');

	// date format on log headers (default: dd/mm/YYYY HH:mm:ss)
	// see http://php.net/date
	public $date_format = 'd/m/Y H:i:s';

	// holds the ipn in a "pretty" way for viewing on logs and emails, can set prefix here
	public $pretty_ipn = "IPN Values received:\n\n";

	// the IPN information received by post will be on this array
	public $ipn = array();

	// the database resource
	protected $dbc;


	// this is where the action is
	public function ipn_is_valid() {

		// loop through the IPN received by POST and do 3 things:
		//  - populate the ipn_data array
		//  - generate a "pretty" list of all ipn variables received (for file logs and e-mails)
		//  - generate the IPN verification string to post back to paypal for validation
		foreach ($_POST as $key => $value) {
			$this->ipn["$key"] = $value;
			$this->pretty_ipn .= "$key: $value\n";
			$req .= "&$key=".urlencode(stripslashes($value));
		}

		// post the ipn back to paypal and exit if invalid
		if(!$this->ipn_postback($req)) {
			return false;
		}

		// got verified
		// do the paypal recommended validations

		// check if payment status is completed
		if($this->ipn['payment_status'] != 'Completed') {
			$this->write_log('WARNING: payment status not completed', $this->pretty_ipn);
			return false;
		}

		// check if it's a duplicate transaction id
		if($this->txn_is_duplicate()) {
			$this->write_log('WARNING: duplicate transaction id detected', $this->pretty_ipn);
			return false;
		}

		// check if it was payed to your e-mail
		if($this->ipn['receiver_email'] != $this->paypal_email) {
			$this->write_log('WARNING: payment was made to different e-mail account', $this->pretty_ipn);
			return false;
		}

		if($this->currencies && !in_array($this->ipn['mc_currency'],$this->currencies)) {
			$this->write_log('WARNING: payment in unsupported currency', $this->pretty_ipn);
			return false;
		}


		// if we didn't return false until now, then everything should be correct
		return true;

	}

	// this method must be called after ipn_is_valid() and all your custom validations have passed
	// it finally updates the database (if active) and logs the valid ipn
	// you can also call it anyway if you want to log invalid ipn's to the database
	public function complete() {
		if(is_resource($this->dbc)) {
			$this->write_db();
		}
		$this->write_log('VALID IPN RECEIVED', $this->pretty_ipn);
	}


	// this method sends the ipn back to paypal
	// returns true if Paypal says verified
	protected function ipn_postback($req) {

		// split the paypal url
		$url_parsed=parse_url($this->paypal_url);

		// connect to paypal
		$socket = fsockopen($url_parsed['host'],80,$err_num,$err_str,30);

		if(!$socket) {
			// could not open the connection. Log it and return
			$this->write_log('WARNING: failed connection to Paypal',"Error establishing connection to paypal\n\nfsockopen error no. $err_num: $err_str");
			return false;

		} else {

			// connected, add the ipn validation cmd and post everything back to PayPal
			$req = 'cmd=_notify-validate' . $req;
			$header .= "POST ".$url_parsed['path']." HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			fputs($socket, $header . $req);

			// loop through the response from the server and assign it to a variable
			while(!feof($socket)) {
				$res .= fgets($socket, 1024);
			}

			// close connection
			fclose($socket);

			// check Paypals response
			if (eregi("VERIFIED",$res)) {
				return true;
			} else {
				$this->write_log('WARNING: invalid IPN detected', $this->pretty_ipn);
				return false;
			}

		}

	}

	// checks for duplicate transaction id
	// ignored when database is off
	// also only now we need to connect to the db if enabled
	protected function txn_is_duplicate() {

		if($this->log_to_db) {
			if($this->connect_db()) {
				if(mysql_num_rows(mysql_query("SELECT txn_id FROM ipn WHERE txn_id='".mysql_real_escape_string($this->ipn['txn_id'],$this->dbc)."'",$this->dbc)) != 0) {
					return true;
				}
			}
		}
		return false;

	}


	// connects to database
	protected function connect_db() {

		$this->dbc = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		if(!$this->dbc) {
			$this->write_log('WARNING: failed connection to database', "Error connecting to database\n\nmysql error no. " . mysql_errno() . ': ' . mysql_error());
			return false;
		} else {
			$db = mysql_select_db($this->db_name, $this->dbc);
			if(!$db) {
				$this->write_log('WARNING: error selecting database',"Error selecting database\n\nmysql error no. " . mysql_errno() . ': ' . mysql_error());
				return false;
			} else {
				return true;
			}
		}

	}


	// writes the log to file and/or sends to email according to preferences
	// parameters:
	//	$log_msg -> short descriptive msg (gets appended to e-mail subjects)
	//  $log_descr -> everyting else, generally the pretty ipn (goes in e-mail body and file logs)
	protected function write_log($log_msg,$log_descr) {

		$thelog = "------------------------------------------------\n";
		$thelog .= '----------- [ '.date($this->date_format).' ] ------------' . "\n";
		$thelog .= "------------------------------------------------\n";
		$thelog .= $log_msg . "\n\n";
		$thelog .= $log_descr . "\n";
		$thelog .= "------------------------------------------------\n";
		$thelog .= "------------------------------------------------\n\n\n\n";

		// log to file if enabled
		if($this->log_to_file) {
			$fp = fopen($this->log_filename,'a');
			fwrite($fp, $thelog);
			fclose($fp);  // close file
		}

		// send email if enabled
		if($this->log_to_email) {
			mail($this->log_email, "$this->log_subject $log_msg", $thelog);
		}

	}

	// write the ipn to the database
	// the hard way because different types of payment send different vars and may mess up the order
	protected function write_db() {
		$sql = 'INSERT INTO ipn VALUES(NULL,';
		$sql .= "'".mysql_real_escape_string($this->ipn['mc_gross'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_status'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payer_id'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['tax'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_street'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payment_date'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payment_status'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['charset'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_zip'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['first_name'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['mc_fee'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_country_code'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_name'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['notify_version'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['custom'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payer_status'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['business'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_country'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_city'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['quantity'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['verify_sign'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payer_email'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['txn_id'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payment_type'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['last_name'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['address_state'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['receiver_email'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payment_fee'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['receiver_id'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['txn_type'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['item_name'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['mc_currency'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['item_number'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['residence_country'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['test_ipn'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['payment_gross'],$this->dbc)."',";
		$sql .= "'".mysql_real_escape_string($this->ipn['shipping'],$this->dbc)."',";
		$sql .= "NOW())";
		//echo $sql;
		mysql_query($sql, $this->dbc);
		// check for insert errors, log the query and the ipn for analysis
		if(mysql_affected_rows() != 1) {
			$this->write_log('WARNING: error saving to database',"SQL query:\n$sql\n\n mysql error no " . mysql_errno() . ': ' . mysql_error() . "\n\n" . $this->pretty_ipn);
		}
	}


}

?>