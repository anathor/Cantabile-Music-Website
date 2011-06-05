<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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

//helper function to create the form
function getNewSubmitForm(){
 var submitForm = document.createElement("FORM");
 document.body.appendChild(submitForm);
 submitForm.method = "POST";
 return submitForm;
}

//helper function to add elements to the form
function createNewFormElement(inputForm, elementName, elementValue){
 var newElement = document.createElement("input");
	newElement.setAttribute("name", elementName);
	newElement.setAttribute("type", "hidden");
 inputForm.appendChild(newElement);
 newElement.value = elementValue;
 return newElement;
}

//function that creates the form, adds some elements
//and then submits it
function createFormAndSubmit()
{
	try
	{
		var aTickets = document.getElementById('adult').value;
		var cTickets = document.getElementById('child').value;

		var submitForm = getNewSubmitForm();
		createNewFormElement(submitForm, "cmd", "_cart");
		createNewFormElement(submitForm, "upload", "1");
		createNewFormElement(submitForm, "business", "natalie@cantabilemusic.com.au");

		var aTicketsNum = parseInt(aTickets, 10);
		var cTicketsNum = parseInt(cTickets, 10);
		var idx = 1;
		if (aTicketsNum > 0)
		{
			createNewFormElement(submitForm, "item_name_" + idx, "Adult Ticket");
			createNewFormElement(submitForm, "quantity_" + idx, aTicketsNum);
			createNewFormElement(submitForm, "amount_" + idx, "15.00");
			idx++;
		}

		if (cTicketsNum > 0)
		{
			createNewFormElement(submitForm, "item_name_" + idx, "Child Ticket");
			createNewFormElement(submitForm, "quantity_" + idx, cTicketsNum);
			createNewFormElement(submitForm, "amount_" + idx, "10.00");
		}

		createNewFormElement(submitForm, "currency_code", "AUD");
		createNewFormElement(submitForm, "cancel_return", "http://www.cantabilemusic.com.au");
		createNewFormElement(submitForm, "return", "http://www.cantabilemusic.com.au/ticketsuccess.php");
		createNewFormElement(submitForm, "rm", "2");

		submitForm.action= "https://www.paypal.com/cgi-bin/webscr";
		submitForm.submit();

	}
	catch (e)
	{
		alert(e.toString());
	}
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
						src="./images/summer/1.jpg"
						width="200px"
						alt="man"
					/>
				</p>
			</div>
			<div id="content">
			<h1>
				Concert Tickets
			</h1>
                <p>
Sutherland Shire Children's Choir Concert</p><p>

Time: 4pm Saturday 18th June 2011<br>
Venue: Engadine Community Centre Auditorium<br>
Address: 1034-1036 Old Princes Highway, Engadine<br>
  (New building located in the Engadine Town Square)</p>
  <p>

  </p>
		<form>
		<p>
		Adult tickets $15 each -
		<input id="adult" value="0" size="4"></p>
		<p>Child tickets $10 each -
		<input id="child" value="0" size="4"><br>
		(3-16yrs)</p><p>
		Press 'Buy Now' to be directed to the Paypal website for payment.  Please make sure that you return to the Cantabile Music website to print your ticket.</p>
		<img src="https://www.paypal.com/en_AU/i/btn/btn_buynowCC_LG.gif" border="0" alt="PayPal - The safer, easier way to pay online." onclick="createFormAndSubmit()">
		</form>
</p>
            </div>
            <br />
            <br />
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
        <script src="footer.js" type="text/javascript"></script>
        </div>
    </div>
</body>
</html>



