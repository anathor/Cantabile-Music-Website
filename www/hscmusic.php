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
				HSC Music Tutoring
			</h1>
			<p>
				Cantabile Music offer private tuition to students preparing for the HSC. Receive the personalised attention that you deserve in a comfortable learning environment that is designed for academic excellence.
			</p>
			<p>
				Tutoring is provided by a music specialist who is an experienced classroom teacher with a thorough knowledge of the Music 1, Music 2 and Extension Courses. Tuition can be used to prepare for written, listening and aural exams, musicology viva voce/essays, compositions and performances.
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
