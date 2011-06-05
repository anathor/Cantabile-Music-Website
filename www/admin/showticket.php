<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="../images/style.css" type="text/css" />
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
		<link rel="stylesheet" href="../style.css" type="text/css"/>
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
			<img src="../images/header.png" width="100%" />
		</div>
		<div id="navbarcontainer">
			<?php include '../navbar.html'; ?>
		</div>
	 	<div id="container">
			<div id="secondcol">
				<p>
					<img
						src="../images/boy.png"
						width="150px"
						alt="man"
					/>
				</p>
			</div>
			<div id="content">
				<h1>
					Concert Tickets
				</h1>
<?php
	$key = $_GET['sch'];

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

	$sql = "select * from Ticket where PrimaryKey='". $key ."'";
	$rs = mysql_query($sql);

	$row = mysql_fetch_array($rs);
	?>
	<p><h3>Thanks for your purchase of
	<?php
	if ($row['Adult'] > 0)
	{
		echo($row['Adult'].' adult ticket');
		if ($row['Adult'] > 1)
			echo('s');

		if ($row['Child'] > 0)
		{
			echo(' and '.$row['Child'].' child ticket');
			if ($row['Child'] > 1)
				echo('s');
		}
	}
	else
	{
		echo($row['Child'].' child tickets');
		if ($row['Child'] > 1)
			echo('s');
	}
	?>!</h3></p>
	<p>Please PRINT THIS OUT and present to gain entry to the auditorium.</p>
Sutherland Shire Children's Choir Concert<br>
Time: Saturday 18th June 2011 4pm<br>
Venue: Engadine Community Centre Auditorium<br>
Address: 1034-1036 Old Princes Highway, Engadine<br>
  (New building located in the Engadine Town Square)</p>

	<?php
	echo ("<p>Paypal Transaction ID: ".$row['TxnToken']."</p>");

	$ticketCode = $row['TicketCode'];
	echo ('<br><img src=../barcode.php?width=300&barcode='.$ticketCode.'&quality=75><br>');

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
