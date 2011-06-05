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
		<link rel="stylesheet" type="text/css" href="./lightbox.css">

		<script language="javascript" src="./prototype.js" type="text/javascript"></script>
		<script language="javascript" src="./mf_lightbox.js" type="text/javascript"></script>

		<script language="javascript" type="text/javascript">
			Event.observe(window, 'load', init, false);

			function init() {
				Lightbox.init();
			}
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
				<p>
					<font color="#400000" size="3" face="Arial">
						Click on the images to enlarge.
					</font>
				</p>
				<table border="0" cellpadding="6" cellspacing="0">
					<tr>
						<td align="center" valign="bottom" width="25%">
							<a href="./images/party/img1.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/party/img1_t.jpg"></a>
						</td>
						<td align="center" valign="bottom" width="25%">
							<a href="./images/party/img2.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/party/img2_t.jpg"></a>
						</td>
						<td align="center" valign="bottom" width="25%">
							<a href="./images/party/img3.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/party/img3_t.jpg"></a>
						</td>
						<td align="center" valign="bottom" width="25%">
							<a href="./images/party/img4.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/party/img4_t.jpg"></a>
						</td>
					</tr>
				</table>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
