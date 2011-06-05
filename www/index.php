<?php
//If the form is submitted
if(isset($_POST['submit'])) {

	//Check to make sure that the name field is not empty
	if(trim($_POST['contactname']) == '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contactname']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['subject']) == '') {
		$hasError = true;
	} else {
		$subject = trim($_POST['subject']);
	}

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['message']) == '') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['message']));
		} else {
			$comments = trim($_POST['message']);
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = 'natalie@cantabilemusic.com.au'; //Put your own email address here
		$body = "Name: $name \n\nEmail: $email \n\nSubject: $subject \n\nComments:\n $comments";
		$headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
	unset($_POST['submit']);
}
?>
<script>
    function btnClear_Click(e)
    {
        document.getElementById('txtStudentId').value = "";
    }
</script>
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
		<script src="jquery.validate.pack.js" type="text/javascript"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			$("#contactform").validate();
		});
		</script>
		<style type="text/css">
			#contact-wrapper div {
				clear:both;
				margin:1em 0;
			}
			#contact-wrapper label {
				display:block;
				float:none;
				font-size:16px;
				width:auto;
			}
			form#contactform input {
				border-color:#B7B7B7 #E8E8E8 #E8E8E8 #B7B7B7;
				border-style:solid;
				border-width:1px;
				padding:5px;
				font-size:16px;
				color:#333;
				width:auto;
			}
			form#contactform textarea {
				font-family:Arial, Tahoma, Helvetica, sans-serif;
				font-size:100%;
				padding:0.6em 0.5em 0.7em;
				border-color:#B7B7B7 #E8E8E8 #E8E8E8 #B7B7B7;
				border-style:solid;
				border-width:1px;
			}
		</style>
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
				<div id="box">
					<h3>Enquiry Form</h3>

					<?php if(isset($hasError)) { //If errors are found ?>
						<p class="error">Please check if you've filled all the fields with valid information. Thank you.</p>
					<?php } ?>

					<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
						<p><strong>Thanks for your email <?php echo $name;?>!</strong></p>
						<p>We will be in touch with you soon.</p>
					<?php } ?>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">
						<div>
							<label for="name"><strong>Name:</strong></label>
							<input type="text" style="width:90%" name="contactname" id="contactname" value="" class="required" />
						</div>

						<div>
							<label for="email"><strong>Email:</strong></label>
							<input type="text" style="width:90%" name="email" id="email" value="" class="required email" />
						</div>

						<div>
							<input type="hidden" style="width:90%" name="subject" id="subject" value="Web Contact Form" class="required" />
						</div>

						<div>
							<label for="message"><strong>Message:</strong></label>
							<textarea rows="5" style="width:90%" name="message" id="message" class="required"></textarea>
						</div>
						<input type="submit" value="Send Message" name="submit" />
					</form>
				</div>
			</div>
			<div id="content">
				<center>
					<img
						src="./images/bigmanmusic.png"
						width="60%"
						alt="man"
					/>
				</center>
				<p>
					<h3><i>Develop your singing voice, musical skills and confidence in an atmosphere of fun and encouragement.</i></h3>
				</p>
				<p>
					<i>Can-ta-bi-le 'In a singing style'</i>
				</p>
				<p>
					Cantabile Music offers quality and affordable music tuition delivered by highly qualified, experienced and passionate teachers. Cantabile Music teachers coach the Sutherland Shire Children’s Choir and Sutherland Shire Early Childhood Music. Our teachers also offer private lessons in singing, piano and HSC music.
				</p>
				<h1>
					Latest News
				</h1>
				<h2>
				Sutherland Shire Children's Choir concert tickets on sale now!
				</h2>
				<p>
				Click on '<a href="./tickets.php">concert tickets</a>' for details and to purchase online.
				</p>
				<h2>
					Watch the Performing Choir at Sutherland Entertainment Centre
				</h2>
				<p>
					The Performing Choir have been invited to sing in the <i>Christmas in July featuring An Evening with the Music of Andre Rieu Spectacular</i>. Tickets are on sale now. Visit the <a href="http://www.sutherlandshire.nsw.gov.au/Arts_Entertainment/Entertainment_Centre/Whats_on/Christmas_in_July_featuring_An_Evening_with_the_Music_of_Andre_Rieu_Spectacular">Sutherland Entertainment Centre website</a> for details and to purchase tickets.
				</p>
				<h2>
					Kurnell Festival Performance
				</h2>
				<p>
					Well done to the Performing Choir for their amazing appearance at the Kurnell Festival! The choir drew a large crowd and received many compliments.
				</p>
				</p>
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
				<br>
				<br>
				<br>
				<br>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
