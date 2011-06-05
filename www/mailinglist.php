<?php

session_start();

$mailinglistresult = "";

if(isset($_POST['txtEmail']))
{
    if( $_POST['txtEmail'] != null)
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

		$sql = "select * from MailingList where Address='". $_POST['txtEmail'] ."'";

		$rs = mysql_query($sql);

		if (mysql_num_rows($rs) == 0)
		{
			$sql = "insert into MailingList(Address) VALUES('". $_POST['txtEmail'] ."')";
			mysql_query($sql);

			$mailinglistresult = "Email address added to list.";
		}
		else
		{
			$mailinglistresult = "Email address already on list.";
		}

		mysql_close($con);
    }
	else
	{
		header('Location: index.php');

		exit;
	}
}
else
{
	header('Location: index.php');

	exit;
}
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
				<br />
				<span class="title_blue">Mailing List</span><br />
				<br />
				<?php
				print $mailinglistresult;
				?>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
