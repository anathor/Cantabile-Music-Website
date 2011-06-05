<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="images/style.css" type="text/css" />
    <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script>
	<script type="text/javascript">

		function PrintElem(elem)
		{
			Popup($(elem).html());
		}

		function Popup(data)
		{
			var mywindow = window.open('', 'print', 'height=400,width=600');
			mywindow.document.write('<html><head><title>print</title>');
			//mywindow.document.write('<link rel="stylesheet" href="style.css" type="text/css" />');
			mywindow.document.write('</head><body >');
			mywindow.document.write(data);
			mywindow.document.write('</body></html>');
			mywindow.document.close();
			mywindow.print();
			mywindow.close();
			return true;
		}

	</script>
    <title>Cantabile Music</title>
</head>
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
			<div id="secondcol">
				<p>
					<img
						src="./images/boy.png"
						width="150px"
						alt="man"
					/>
				</p>
			</div>
			<div id="content">
				<?php
					$tx_token = $_GET['tx'];
					// read the post from PayPal system and add 'cmd'
					$req = 'cmd=_notify-synch';

					$auth_token = "dNuuPmjSn5Rg8LayH81bUoAr0sFwKBTZhNh_DAEId0aOTk-IxNQKlcDSF3K";
					$req .= "&tx=$tx_token&at=$auth_token";

					// post back to PayPal system to validate
					$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
					$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
					$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

					$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
					if (!$fp)
					{
						die('Failed to connect to PayPal, Please contact support');
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
					}

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
							echo ($valName ." - ". $valVal."<br>");
						}
					}

					$txnid = $keyarray['txn_id'];
					if ($txnid == "")
					{
						die('Failed to find transaction, please contact natalie@cantabilemusic.com.au');
					}

					$firstname = $keyarray['first_name'];
					$lastname = $keyarray['last_name'];
					$itemname = $keyarray['item_name'];
					$amount = $keyarray['mc_gross'];
					$qty = $keyarray['quantity'];
					$subject = $keyarray['transaction_subject'];

					fclose ($fp);
					}
					die('Finished');

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
						$sql = "INSERT INTO Ticket(TicketCode, TxnToken, Tickets) VALUES('".v5()."','".$txnid."','".$qty."')";
						mysql_query($sql);

						$sql = "select * from Ticket where TxnToken='". $txnid ."'";
						$rs = mysql_query($sql);
					}

					$row = mysql_fetch_array($rs);

					$qty = $row['Tickets'];
					?>
					<h1>
						Choir Fees
					</h1>
					<?php
					echo ("<p><h3>Thanks for your purchase of ".$qty." tickets!</h3></p>");
					echo ("<p>The barcode below is for all tickets purchased.</p>");
					echo ("<p>Please PRINT THIS OUT and present to gain entry to the auditorium.</p>");

					echo ("<p>Sutherland Shire Children’s Choir Concert</p>");
					echo ("<p>Date:  	    Saturday 4th December 2010</p>");
					echo ("<p>Doors open: 3.50pm</p>");
					echo ("<p>Concert:    4.00pm</p>");
					echo ("<p>Venue:</p>");
					echo ("<p>			Engadine Community Centre</p>");
					echo ("<p>			1040 Old Princess Hwy</p>");
					echo ("<p>			Engadine NSW 2233</p>");
					echo ("<p>			(Adjacent to the newly developed Engadine Town Square)</p>");

					echo ("<p>Paypal Transaction ID: ".$row['TxnToken']."</p>");

					$sql = "select * from Ticket where TxnToken='". $txnid ."'";
					$rs = mysql_query($sql);

					while($row = mysql_fetch_array($rs))
					{
						$ticketCode = $row['TicketCode'];
						echo ("<br><IMG SRC=\"barcode.php?width=700&barcode=".$ticketCode."&quality=75\"><br>");
					}


					mysql_close($con);
				?>
				<input type="button" value="Print" onclick="PrintElem('#content')" />
			</div>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
