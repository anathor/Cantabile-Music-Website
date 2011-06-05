<?php

session_start();

if( isset($_POST['txtStudentId']))
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
}

if( isset($_SESSION['studentId']) )
{
    if(isset($_SESSION['nextPage']))
    {
        header("Location: " .$_SESSION['nextPage']);
        unset($_SESSION['nextPage']);
    }
    else
    {
        header('Location: student.php');
    }

    exit;
}
?>

<script>
    function btnClear_Click(e)
    {
        document.getElementById('txtStudentId').value = "";
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
		<div id="banner">
			<img src="./images/header.png" width="100%" />
		</div>
        <div id="content">
            <div id="contenttext">
                <br />
                <span class="title_blue">Student Login</span><br />
                <br>
                <p class="body_text" align="justify">
                    <form id="frmLogin" method="post" action="login.php">
                        Student Id: <input id="txtStudentId" name="txtStudentId" type="text" value="<?php if( isset($_POST['txtStudentId']) ) print $_POST['txtStudentId']; ?>" />
                        <br />
                            <?php

                                if( isset($_POST['txtStudentId']) && $_POST['txtStudentId'] == null )
                                    print "Error: Student Id cannot be blank.";

                            ?>
                            <?php

                                if( $error )
                                {
                                    print $error;
                                    $error = null;
                                }

                            ?>
                        <br />
                        <input id="btnSubmit" type="Submit" value="Login" />
                        <input id="btnClear" type="Button" value="Clear" onclick="btnClear_Click(event)" />
                    </form>
                </p>
            </div>
            <br />
            <br />
        <script src="footer.js" type="text/javascript"></script>
        </div>
    </div>
</body>
</html>


