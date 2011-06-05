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
			<div id="content">
				<p>
					<font color="#400000" size="3" face="Arial">
						Click on the images to enlarge.
					</font>
				</p>
				<table border="0" cellpadding="4" cellspacing="0">
					<tr>
						<td align="center" valign="bottom" width="30%">
							<a href="./images/winter/img1.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img1_t.jpg"></a>
						</td>
						<td align="center" valign="bottom" width="30%">
							<a href="./images/winter/img2.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img2_t.jpg"></a>
						</td>
						<td align="center" valign="bottom" width="30%">
							<a href="./images/winter/img10.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img10_t.jpg"></a>
						</td>
						<td align="center" valign="bottom" width="30%">
							<a href="./images/winter/img4.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img4_t.jpg"></a>
						</td>
					</tr>
					<tr>
						<td align="center" valign="bottom">
							<a href="./images/winter/img5.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img5_t.jpg"></a>
						</td>
						<td align="center" valign="bottom">
							<a href="./images/winter/img6.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img6_t.jpg"></a>
						</td>
						<td align="center" valign="bottom">
							<a href="./images/winter/img7.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img7_t.jpg"></a>
						</td>
						<td align="center" valign="bottom">
							<a href="./images/winter/img8.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img8_t.jpg"></a>
						</td>
					</tr>
					<tr>
						<td align="center" valign="bottom">
							<a href="./images/winter/img9.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img9_t.jpg"></a>
						</td>
						<td align="center" valign="bottom">
							<a href="./images/winter/img3.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img3_t.jpg"></a>
						</td>
						<td align="center" valign="bottom">
							<a href="./images/winter/img11.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img11_t.jpg"></a>
						</td>
					</tr>
					<tr>
						<td align="center" valign="bottom">
							<a href="./images/winter/img12.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img12_t.jpg"></a>
						</td>
						<td align="center" valign="bottom">
							<a href="./images/winter/img13.jpg" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="./images/winter/img13_t.jpg"></a>
						</td>
					</tr>
				</table>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
