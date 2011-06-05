<?php

session_start();

if(isset($_POST['txtStudentId']))
{
    if( $_POST['txtStudentId'] != null)
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

        $sql = "select * from Student where StudentId='". $_POST['txtStudentId'] ."'";

        $rs = mysql_query($sql);

        if( mysql_num_rows($rs) >= 1 )
        {
            $_SESSION['studentId'] = $_POST['txtStudentId'];
        }
        else
        {
            $error = "Student Id not found";
        }

        mysql_close($con);

    }
	else if(!isset($_SESSION['studentId']) )
    {
        $_SESSION['nextPage'] = "student.php";
        header('Location: index.php');
        exit;
    }
}

if(!isset($_SESSION['studentId']) )
{
	$_SESSION['nextPage'] = "student.php";
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
				<span class="title_blue">Student Options</span><br />
				<br />
				<span class="title2_blue"><a href="payfees.php">Pay Fees</a></span><br><br>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
