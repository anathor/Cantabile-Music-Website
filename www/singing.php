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
			<h1>
				Private Singing Lessons
			</h1>
			<p>
				Cantabile Music offers private singing lessons to children and adults. We teach beginners who want to learn the basics, students preparing for HSC/AMEB exams and advanced singers wanting to perfect their technique.
			</p>
			<p>
				The programme is individually designed to cater to each singer's vocal needs. Students learn how to protect their voice, improve pitch and tone, extend vocal range and develop breath and vocal control. Songs are used that suit each singer's skill level, vocal type and interests.
			</p>
			<p>
				Lessons are offered weekly for 30 mins ($30), 45 mins ($43) or 1 hr ($53). Please contact us to organise a free trial lesson.
			</p>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
