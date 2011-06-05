<?php
    session_start();

	$action = $_POST['action'];
	if ($action == "login" && $_POST['secret'] == "bumbleface")
	{
		$_SESSION['loggedin'] = true;
	}

    if(!isset($_SESSION['loggedin']) )
    {
?>
<html>
	<head>
		<title>
			Admin
		</title>
	</head>
	<body>
		<form action="./index.php" method="post">
			<h1>Login</h1>
			Secret: <input id="secret" name="secret" size=100><br>
			<input type="hidden" name="action" value="login">
			<input type="submit">
		</form>
	</body>
</html>
<?php
    }
    else
    {
		if ($action == "ticketsearch")
		{
			$email = $_POST['email'];

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

			$sql = "select * from Ticket where payer_email='". $email ."'";
			$rs = mysql_query($sql);
			$rows = mysql_num_rows($rs);

			if ($rows == 1)
			{
				$row = mysql_fetch_array($rs);
				header('Location: ./showticket.php?sch='. $row['PrimaryKey']);
				exit;
			}
			else
			{
?>
<html>
	<head>
		<title>
			Admin
		</title>
	</head>
	<body>
<?php
				while($row = mysql_fetch_array($rs))
				{
					echo('<a href="./showticket.php?sch='. $row['PrimaryKey'] .'">Show Ticket</a><br>');
				}
?>
	</body>
</html>

<?php
			}
		}
		else if ($action == "ticketcreate")
		{
			function v5()
			{
				$uuidobject;
				uuid_create ( &$uuidobject );
				uuid_make ( $uuidobject, UUID_MAKE_V4 );
				uuid_export ( $uuidobject, UUID_FMT_STR, &$uuidstring );
				return trim ( $uuidstring );
			}

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

			$isunique = 1;
			while ($isunique > 0)
			{
				$code = strtoupper(substr(v5(), -6));

				$sql = "select * from Ticket where TicketCode='". $code ."'";

				$rs = mysql_query($sql);

				$isunique = mysql_num_rows($rs);
			}

			$sql = "INSERT INTO Ticket(TicketCode, Adult, Child, payer_email) VALUES('".$code."','".$_POST['adult']."','".$_POST['child']."','".$_POST['email']."')";
			mysql_query($sql);

			$sql = "select * from Ticket where TicketCode='". $code ."'";
			$rs = mysql_query($sql);

			$row = mysql_fetch_array($rs);

			header('Location: ./showticket.php?sch='. $row['PrimaryKey']);
			mysql_close($con);
			exit;
		}
		else
		{
?>

<html>
	<head>
		<title>
			Admin
		</title>
	</head>
	<body>
		<form action="./index.php" method="post">
			<h1>Find Tickets</h1>
			Email: <input id="email" name="email" size=100><br>
			<input type="hidden" name="action" value="ticketsearch">
			<input type="submit">
		</form>
		<form action="./index.php" method="post">
			<h1>Make Tickets</h1>
			Email: <input id="email" name="email" size=100><br>
			Adult: <input id="adult" name="adult" size=100><br>
			Child: <input id="child" name="child" size=100><br>
			<input type="hidden" name="action" value="ticketcreate">
			<input type="submit">
		</form>
	</body>
</html>

<?php

		}
	}
?>