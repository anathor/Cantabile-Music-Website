<?php

session_start();

?>
<html>
    <head>
        <title>Cantabile Music</title>
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<script type="text/javascript">
		sfHover = function()
		{
			var sfEls = document.getElementById("navbar").getElementsByTagName("li");
			for (var i=0; i<sfEls.length; i++) {
				sfEls[i].onmouseover=function() {
					this.className+=" hover";
				}
				sfEls[i].onmouseout=function() {
					this.className=this.className.replace(new RegExp(" hover\\b"), "");
				}
			}
		}
		if (window.attachEvent) window.attachEvent("onload", sfHover);
		</script>
    </head>
    <body style="filter:progid:DXImageTransform.Microsoft.Gradient(endColorstr='#1F52CD', startColorstr='#9522B3', gradientType='1');">
		<div id="banner">
			<img src="./images/header.png" width="100%" />
		</div>
		<div id="navbarcontainer">
			<?php include 'navbar.html'; ?>
		</div>
	 	<div id="container">
			<div id="content">
<?php

error_log("tTT", 3, "/var/tmp/my-errors.log");

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';

$tx_token = $_GET['tx'];
error_log('tx token'.$tx_token, 0);
$auth_token = "dNuuPmjSn5Rg8LayH81bUoAr0sFwKBTZhNh_DAEId0aOTk-IxNQKlcDSF3K";
$req .= "&tx=$tx_token&at=$auth_token";

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('sandbox.paypal.com', 80, $errno, $errstr, 30);

if (!$fp)
{
    print "http error1";
    die('Could not connect to PayPal');
}
else
{
	fputs ($fp, $header . $req);
	// read the body data
	$res = '';
	$headerdone = false;
	while (!feof($fp))
	{
		$line = fgets ($fp, 1024);
		if (strcmp($line, "\r\n") == 0)
		{
			// read the header
			$headerdone = true;
		}
		else if ($headerdone)
		{
			// header has been read. now read the contents
			$res .= $line;
		}
	}

	// parse the data
	$lines = explode("\n", $res);
	$keyarray = array();
	if (strcmp ($lines[0], "SUCCESS") == 0)
	{
		for ($i=1; $i<count($lines);$i++)
		{
			list($key,$val) = explode("=", $lines[$i]);
			$keyarray[urldecode($key)] = urldecode($val);
			$valName = urldecode($key);
			$valVal = urldecode($val);
			error_log($valName ." - ". $valVal, 0);
		}
		// check the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your Primary PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment
		$txnid = $keyarray['txn_id'];
		$firstname = $keyarray['first_name'];
		$lastname = $keyarray['last_name'];
		$itemname = $keyarray['item_name'];
		$amount = $keyarray['mc_gross'];
		$qty = $keyarray['quantity'];
		$receipt_id = $keyarray['receipt_id'];
		$_SESSION['studentId'] = $keyarray['transaction_subject'];

		$dbusername = "cantabilemusic";
		$dbpassword = "claire";
		$database = "cantabilemusic";

		if( !$con = @mysql_connect('localhost', $dbusername, $dbpassword) )
		{
			// perhaps log this error here rather than outputting to the screen cause it will push
			// database name to the screen
			die('Could not connect to database: ' . mysql_error());
		}

		mysql_select_db($database);

		$sql = "select * from FeePayments where TxnId='". $txnid ."'";

		$rs = mysql_query($sql);

		if( mysql_num_rows($rs) == 0 )
		{
			$sql = "INSERT INTO FeePayments(StudentId, TxnId, Receipt) VALUES('".$_SESSION['studentId']."','".$txnid."','".$receipt_id."')";
			mysql_query($sql);
		}

		echo ("<p><h3>Thank you for your payment!</h3></p>");

		echo ("<b>Payment Details</b><br>\n");
		echo ("<li>Name: $firstname $lastname</li>\n");
		echo ("<li>Item: $itemname</li>\n");
		echo ("<li>Amount: $amount</li>\n");

		mysql_close($con);

	}
	else if (strcmp ($lines[0], "FAIL") == 0)
	{
		// log for manual investigation
		echo ("<p><h3>A problem has occured, please contact Cantabile Music</h3></p>");
	}

}
fclose ($fp);
?>
<form><input type="button" value="Print" onclick="window.print();"></form>



                	</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>



