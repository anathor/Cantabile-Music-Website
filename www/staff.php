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
					Staff
				</h1>
				<h2>
					Natalie Pocock (Managing Director)
				</h2>
				<p>
					Natalie is a highly skilled, experienced and enthusiastic music teacher.
				</p>
				<p>
					Natalie graduated from UNSW with a Bachelor of Music Education majoring in voice. Natalie is always eager to gain new skills and knowledge. She has completed courses such as the Orff Schulwerk Certificate of Accreditation and continues to attend Kodaly conferences and the annual Choral Conductors Summer School in Melbourne.
				</p>
				<p>
					Natalie has experience teaching music in early childhood settings and at various primary and high schools. She has enjoyed her varied and demanding roles that have included classroom teaching, development of school curriculum, vocal/piano/HSC music tutoring, running of school musicals and the preparation for performances.
				</p>
				<p>
					Natalie’s passion has always been working with choirs. Her expert knowledge of the voice and performance experience has complemented her choral skills. She has run successful primary and high school choirs. Natalie has produced spectacular performances, often combined with other choirs. She has experience as a Director of Music at the Australian Youth Choir where she was called upon to direct rehearsals, conduct at various concerts and to run many auditions across Sydney. Natalie now enjoys her role as the Director of Sutherland Shire Children’s Choir.
				</p>
				<h2>
					Ruth Propert-Beeton
				</h2>
				<p>
					Ruth completed a Bachelor of Music Education in 1984, spending approx. 7 years working in the public education system as a secondary music teacher. During this time Ruth gained experience teaching various types of choral and instrumental groups. Ruth’s broad musical experience also includes stage musicals, solo work, rock bands and some recording experience.
				</p>
				<p>
					In 1988 Ruth was chosen as one of the conductors for the Bicentennial Mass Band. Ruth’s experience as an accompanist spans 30 years, from accompanying school choir at the age of 15, to weddings, student exams and other various functions. Currently, Ruth is working with a local school, training, assisting and accompanying rehearsals and performances for events such as the NSW Primary Choral Festival at the Opera House, the Hunter Regional Choral Festival, the Lake Macquarie Performing Arts Festival and the Newcastle Eisteddfod.
				</p>
				<p>
					Ruth has worked with NIYPAA as a conductor and Director of Music for the Australian Youth Choir at the Newcastle venue since 2003, as well as accompanist for the Parramatta venue. She believes the choral experience should be a positive one that gives the students a life-long love of music and singing. Aside from her music, Ruth occasionally appears as an acting extra for TV and Film.
				</p>
				<h2>
					Thomas Chiu
				</h2>
				<p>
					Thomas graduated from the Sydney Conservatorium of Music with a Bachelor of Music Studies majoring in piano performance. Thomas has extensive experience as an accompanist, including playing for HSC performers, church choral groups, and Sydney Conservatorium performance workshops.  
				</p>
				<p>
					In addition to performing as an accompanist, he enjoys performing a wide range of solo works including premiering new compositions at concerts. Thomas has a particularly keen interest in choral music, and has been a member of various singing groups including the Sydney Conservatorium Chamber Choir. Thomas is passionate, energetic and thoroughly enjoys working with children. He strives to inspire young musicians to learn and experience the joys of music, whilst having fun!
				</p>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
