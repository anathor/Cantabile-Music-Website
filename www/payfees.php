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
				<h2>Pay Fees Online</h2>
                <p class="body_text" align="justify">
					Pay your choir fees online via PayPal.
					<br>
					<br>
					Please enter your child's first and last name and press the button below.<br><br>
					A sibling discount is included where applicable.<br><br>
					Please note that by choosing to pay via PayPal, an extra 2% charge is included to recover merchant fees.
					<br>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="AS98F5WFL98P6">
					<table>
					<tr><td><input type="hidden" name="on0" value="Number of Children">Number of Children</td></tr><tr><td><select name="os0">
						<option value="1 Child for Choir">1 Child for Choir $448.80</option>
						<option value="2 Children for Choir">2 Children for Choir $856.80</option>
						<option value="1 Child for Early Childhood">1 Child for Early Childhood $224.40</option>
						<option value="1 Child for Choir, 1 Child for Early Childhood">1 Child for Choir, 1 Child for Early Childhood $652.80</option>
						<option value="2 Children for Choir, 1 Child for Early Childhood">2 Children for Choir, 1 Child for Early Childhood $1,060.08</option>
					</select> </td></tr>
					<tr><td><input type="hidden" name="on1" value="Child's/Children's Name(s)">Child's/Children's Name(s)</td></tr><tr><td><input type="text" name="os1" maxlength="60"></td></tr>
					</table>
					<input type="hidden" name="currency_code" value="AUD">
					<input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
					<img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
					</form>
					<br>
                </p>
			</div>
			<div id="footer">
			</div>
		</div>
    </body>
</html>
