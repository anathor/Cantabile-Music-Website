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
				<br/>
					<span class="title2_blue"><a href="./summer.php">Sutherland Shire Children's Choir</a></span><br/><span class="title2_blue"><a href="./summer.php">End of Year Concert 2010</a></span><br />
						<br />
					<span class="title2_blue"><a href="./winter.php">Sutherland Shire Children's Choir</a></span><br/><span class="title2_blue"><a href="./winter.php">Mid-Year Concert 2010</a></span><br />
						<br />
					<span class="title2_blue"><a href="./party.php">Sutherland Shire Children's Choir</a></span><br/><span class="title2_blue"><a href="./party.php">Party Rehearsals 2010</a></span><br />
						<br />
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
