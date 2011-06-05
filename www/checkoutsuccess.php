<?php

    session_start();

    if( ! isset($_SESSION['studentId']) )
    {
        $_SESSION['nextPage'] = "buytickets.php";
        header('Location: login.php');
        exit;
    }

    if( ! isset($_SESSION['tickets']) )
    {
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

        $sql = "select * from Student where StudentId='". $_SESSION['studentId'] ."'";

        $rs = mysql_query($sql);

        if( mysql_num_rows($rs) == 1 )
        {
            $_SESSION['tickets'] = 2;
        }

        mysql_close($con);
    }
?>

<script>
    function btnClear_Click(e)
    {
        document.getElementById('txtTicketsRequested').value = "";
    }
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="images/style.css" type="text/css" />
    <title>Cantabile Music</title>
</head>
<body>
    <div id="page" align="center">
    <body style="filter:progid:DXImageTransform.Microsoft.Gradient(endColorstr='#1F52CD', startColorstr='#9522B3', gradientType='1');">
		<div id="banner">
			<img src="./images/header.png" width="100%" />
		</div>
		<div id="navbarcontainer">
			<?php include 'navbar.html'; ?>
		</div>
        <div id="content">
            <div id="contenttext">
                <br />
                <span class="title_blue">Tickets Purchased</span><br />
                <br />
                <p class="body_text" align="justify">
                    <br>
<?php

session_start();

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';

$tx_token = $_GET['tx'];
$auth_token = "dNuuPmjSn5Rg8LayH81bUoAr0sFwKBTZhNh_DAEId0aOTk-IxNQKlcDSF3K";
$req .= "&tx=$tx_token&at=$auth_token";

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
// If possible, securely post back to paypal using HTTPS
// Your PHP server will need to be SSL enabled
// $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) {
    print "http error1";
} else {
fputs ($fp, $header . $req);
// read the body data
$res = '';
$headerdone = false;
while (!feof($fp)) {
$line = fgets ($fp, 1024);
if (strcmp($line, "\r\n") == 0) {
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
if (strcmp ($lines[0], "SUCCESS") == 0) {
for ($i=1; $i<count($lines);$i++){
list($key,$val) = explode("=", $lines[$i]);
$keyarray[urldecode($key)] = urldecode($val);
$valName = urldecode($key);
$valVal = urldecode($val);
 //echo ($valName ." - ". $valVal."<br>");
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

$sql = "select * from Ticket where TxnToken='". $txnid ."'";

$rs = mysql_query($sql);

if( mysql_num_rows($rs) == 0 )
{
    for ( $counter = 0; $counter < $qty; $counter += 1) {
        $ticketCode = uniqid();
        $ticketCode = strtoupper($ticketCode);
        $sql = "INSERT INTO Ticket(StudentId, TicketCode, TxnToken) VALUES('".$_SESSION['studentId']."','".$ticketCode."','".$txnid."')";
        mysql_query($sql);
    }
}

$sql = "select * from Ticket where TxnToken='". $txnid ."'";
$rs = mysql_query($sql);

echo ("<p>Student Id:".$_SESSION['studentId']."</p>");

echo ("<p><h3>Thank you for your purchase!</h3></p>");
echo ("<p>Each barcode below is a ticket. Please print these out and bring to the concert. If you are unable to print out the barcodes please make note of the barcode numbers instead.</p>");

echo ("<b>Payment Details</b><br>\n");
echo ("<li>Name: $firstname $lastname</li>\n");
echo ("<li>Item: $itemname</li>\n");
echo ("<li>Amount: $amount</li>\n");
echo ("<br>Choir concert at the Len Wallis Auditorium, Sutherland Uniting Church, cnr Flora & Merton Streets Sutherland. Saturday 19th June 3:30pm.<br>");
while($row = mysql_fetch_array($rs))
{
    $ticketCode = $row['TicketCode'];
    echo ("<br><IMG SRC=\"barcode.php?width=400&barcode=".$ticketCode."&quality=75\"><br>");
}


mysql_close($con);

}
else if (strcmp ($lines[0], "FAIL") == 0) {
// log for manual investigation
    echo ("<p><h3>A problem has occured, please contact Cantabile Music</h3></p>");
}

}

fclose ($fp);

?>
<form><input type="button" value="Print" onclick="window.print();"></form>



                </p>
            </div>
            <br />
            <br />
        <script src="footer.js" type="text/javascript"></script>
        </div>
    </div>
</body>
</html>



