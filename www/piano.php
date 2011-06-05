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
				Private Piano Lessons
			</h1>
			<p>
				Cantabile Music offers private piano lessons to children (5yrs and older) and adults. Learn from an experienced and encouraging teacher. Receive well rounded tuition from a music education specialist who uses effective teaching strategies that cater to the learning style, age and experience of each student. Proven methods are used for motivating home practise. Lessons are enjoyable, engaging and inspire students towards a lifelong enjoyment of playing music.
			</p>
			<p>
				Songs are used that suit each student’s interests and needs. There is the opportunity to prepare for Australian Music Examinations Board practical and theory exams with the advantage of a teacher who has extensive knowledge of the syllabus requirements and standards.
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
