<?

// made by robin kohli (robin@19.5degs.com) for 19.5 Degrees (http://www.19.5degs.com)

// ----- edit these settings

// database settings
$host="localhost";
$ln="";
$pw="";
$db="";

// paypal email
$paypal_email = "your.paypal@email.address";

// email address where script should send notifications
$error_email = "your@email.address";

// email header
$em_headers  = "From: from_name <from_email>\n";		
$em_headers .= "Reply-To: from_email\n";
$em_headers .= "Return-Path: from_email\n";
$em_headers .= "Organization: company_name\n";
$em_headers .= "X-Priority: 3\n";


// -----------------


require("ipn_cls.php");

$paypal_info = $HTTP_POST_VARS;
$paypal_ipn = new paypal_ipn($paypal_info);

foreach ($paypal_ipn->paypal_post_vars as $key=>$value) {
	if (getType($key)=="string") {
		eval("\$$key=\$value;");
	}
}

$paypal_ipn->send_response();
$paypal_ipn->error_email = $error_email;

if (!$paypal_ipn->is_verified()) {
	$paypal_ipn->error_out("Bad order (PayPal says it's invalid)" . $paypal_ipn->paypal_response , $em_headers);
	die();
}


switch( $paypal_ipn->get_payment_status() )
{
	case 'Pending':
		
		$pending_reason=$paypal_ipn->paypal_post_vars['pending_reason'];
					
		if ($pending_reason!="intl") {
			$paypal_ipn->error_out("Pending Payment - $pending_reason", $em_headers);
			break;
		}


	case 'Completed':
		
		$qry= "SELECT i.mc_gross, i.mc_currency FROM item_table as i WHERE i.item_number='$item_number'";
		mysql_connect("$host","$ln","$pw") or die("Unable to connect to database");
		mysql_select_db("$db") or die("Unable to select database");
		$res=mysql_query ($qry);
		$config=mysql_fetch_array($res);
	
		if ($paypal_ipn->paypal_post_vars['txn_type']=="reversal") {
			$reason_code=$paypal_ipn->paypal_post_vars['reason_code'];
			$paypal_ipn->error_out("PayPal reversed an earlier transaction.", $em_headers);
			// you should mark the payment as disputed now
		} else {
					
			if (
				(strtolower(trim($paypal_ipn->paypal_post_vars['business'])) == $paypal_email) && (trim($mc_currency)==$config['mc_currency']) && (trim($mc_gross)-$tax == $quantity*$config['mc_gross']) 
				) {

				$qry="INSERT INTO paypal_table VALUES (0 , '$payer_id', '$payment_date', '$txn_id', '$first_name', '$last_name', '$payer_email', '$payer_status', '$payment_type', '$memo', '$item_name', '$item_number', $quantity, $mc_gross, '$mc_currency', '$address_name', '".nl2br($address_street)."', '$address_city', '$address_state', '$address_zip', '$address_country', '$address_status', '$payer_business_name', '$payment_status', '$pending_reason', '$reason_code', '$txn_type')";
				
				
				if (mysql_query($qry)) {

					$paypal_ipn->error_out("This was a successful transaction", $em_headers);			
					// you should add your code for sending out the download link to your customer at $payer_email here.

				} else {
					$paypal_ipn->error_out("This was a duplicate transaction", $em_headers);
				} 
			} else {
				$paypal_ipn->error_out("Someone attempted a sale using a manipulated URL", $em_headers);
			}
		}
		break;
		
	case 'Failed':
		// this will only happen in case of echeck.
		$paypal_ipn->error_out("Failed Payment", $em_headers);
	break;

	case 'Denied':
		// denied payment by us
		$paypal_ipn->error_out("Denied Payment", $em_headers);
	break;

	case 'Refunded':
		// payment refunded by us
		$paypal_ipn->error_out("Refunded Payment", $em_headers);
	break;

	case 'Canceled':
		// reversal cancelled
		// mark the payment as dispute cancelled		
		$paypal_ipn->error_out("Cancelled reversal", $em_headers);
	break;

	default:
		// order is not good
		$paypal_ipn->error_out("Unknown Payment Status - " . $paypal_ipn->get_payment_status(), $em_headers);
	break;

} 

?>