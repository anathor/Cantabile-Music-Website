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
					Music Games
				</h1>
	            <p>
	            	It’s time to have some fun with musical games!  Click on the following links to be directed to great music websites for kids.
	            </p>
                <a href="http://www.dsokids.com">www.dsokids.com</a>
                <br />
                <br />
                <a href="http://www.sfskids.com">www.sfskids.com</a>
                <br />
                <br />
                <a href="http://www.nyphilkids.org">www.nyphilkids.org</a>
                <br />
                <br />
                <a href="http://www.artsalive.ca/en/mus/instrumentlab">www.artsalive.ca/en/mus/instrumentlab</a>
                <br />
                <br />
                <a href="http://www.thirteen.org/publicarts/orchestra/index.html">www.thirteen.org/publicarts/orchestra/index.html</a>
                <br />
                <br />
                <a href="http://www.quia.com/rr/4048.html">www.quia.com/rr/4048.html</a>
                <br />
                <br />
                <a href="http://www.playmusic.org">www.playmusic.org</a>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
