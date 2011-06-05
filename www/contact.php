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
						src="./images/contact.jpg"
						width="90%"
						alt="man"
					/>
				</p>
			</div>
			<div id="content">
				<h1>
					Contact Us
				</h1>
				<p>
					Please feel free to contact us for further information.
				</p>
				<p>
					Natalie Pocock (Director)
					<br/>
					<br/>
					Email: <a href="mailto:natalie@cantabilemusic.com.au">natalie@cantabilemusic.com.au</a>
					<br/>
					<br/>
					Ph:&nbsp;&nbsp;&nbsp;&nbsp;0415796095
					<br/>
					<br/>
					Post: Cantabile Music
					<br/>
					<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PO BOX 447
					<br/>
					<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sutherland NSW 1499
				</p>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
