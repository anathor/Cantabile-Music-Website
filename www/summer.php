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
<?php

$arr = array
(
	"1.jpg",
	"2.jpg",
	"3.jpg",
	"4.jpg",
	"5.jpg",
	"6.jpg",
	"7.jpg",
	"200.jpg",
	"202.jpg",
	"203.jpg",
	"228.jpg",
	"231.jpg",
	"233.jpg",
	"235.jpg",
	"237.jpg",
	"244.jpg",
	"249.jpg",
	"312.jpg",
	"323.jpg",
	"329.jpg",
	"330.jpg",
	"333.jpg",
	"341.jpg",
	"344.jpg",
	"348.jpg",
	"351.jpg",
	"352.jpg",
	"353.jpg",
	"354.jpg",
	"368.jpg",
	"373.jpg",
	"376.jpg",
	"381.jpg",
	"384.jpg",
	"404.jpg",
	"413.jpg",
	"499.jpg",
	"519.jpg",
	"528.jpg",
	"542.jpg",
	"553.jpg",
	"556.jpg",
	"562.jpg",
	"563.jpg",
	"565.jpg",
	"566.jpg",
	"568.jpg",
	"570.jpg",
	"576.jpg",
	"579.jpg",
	"580.jpg",
	"581.jpg",
	"592.jpg",
	"594.jpg",
	"595.jpg",
	"596.jpg",
	"597.jpg",
	"599.jpg"
);
?>
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
					<?php
						$cnt = 0;

						foreach ($arr as &$value)
						{
							if ($cnt == 4)
							{
								echo('</tr><tr>');
								$cnt = 0;
							}
					?>
								<td align="center" valign="bottom" width="30%">
									<?php echo ('<a href="./images/summer/'.$value.'" onClick="Lightbox.showBoxImage(this.href);return false;"><img src="thumb.php?file=images/summer/'.$value.'&size=120"></a>'); ?>
								</td>
					<?php
							$cnt++;
						}
					?>
					</tr>
				</table>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
