<?php
	//require the class include file
	require_once('paypal.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Paypal Buttons Example</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<style type="text/css" media="screen">
		body {
			font-family:Arial, Helvetica, sans-serif;
			font-size:100%;
		}
		
		h3 {
		  border-bottom:2px solid #993366;
		}
		
		p, li {
 			font-size:12px;
		}
		
		a {
			text-decoration:none;
		}
		a:link, a:visited {
			color:#6666CC;
		}
		a:hover {
			text-decoration:underline;
			color:#FF0000;
		}
		
		div.button {
			border:1px solid #ccc;
			background-color:#D1EAEF;
			padding:10px;
			font-size:12px;
		}
		div.button form {
			padding:0;
			margin:0;
		}
		pre {
			font-size:12px;
		}
		dl {
			font-size:12px;
			margin:0 20px 0 20px;
		}
		dl dt {
			font-weight:bold;
			color:#993333;
		}
		dl dd {
			margin:0 0 5px 20px;
		}
		.red {
			color:#f00;
		}
	</style>
</head>

<body>

<h3>PHP Class: Paypal Button Generator</h3>
<p><a href="http://www.jc21.com">jc21.com</a> - <strong><a href="http://blog.jc21.com/2006-06-12/paypal-button-generator/">Get the latest version</a></strong></p>

<p>So you've decided to get your hands dirty and make some online transactions! Great!
<a href="http://www.paypal.com.au">Paypal</a> is one of the biggest payment gateways you can use. This class will create 
buttons dynamically for you. So it's ideal to use for Shopping carts. A word of warning though,
just because you've created the button doesn't mean you job is over! After the payment process is completed (or cancelled)
a number of variables (in either POST or GET form) are passed back where you want them. So I recommend doing your
research with Paypal. An extensive whitepaper about the buttons can be found <a href="https://www.paypal.com/au/cgi-bin/webscr?cmd=p/pdn/howto_checkout-outside#methodone">here</a>.
I also recommend learning the IPN part of Paypal, as it's so much more secure, and won't be covered here. So, let's get started!</p>

<ul>
	<li><a href="#overview">Class Overview</a></li>
	<li><a href="#example1">Example 1: A Single Item Purchase</a></li>
	<li><a href="#example2">Example 2: A Multiple Item Purchase (shopping cart)</a></li>
	<li><a href="#example3">Example 3: Subscription Button</a></li>
</ul>


<h3><a name="overview">Class Overview</a></h3>

<p><strong>Class Declaration</strong></p>
<pre style="border: 1px solid rgb(204, 204, 153); background-color: rgb(255, 255, 204);"><a href="http://www.php.net/require_once"><span style="color: rgb(161, 161, 0);" title="php/php/keyword">require_once</span></a><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">paypal.inc.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
<span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(161, 161, 0);" title="php/php/keyword">new</span> <span style="color: rgb(153, 51, 51);" title="php/php/classname">PayPalButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span></pre>

<p><strong>Class Variables</strong></p>

<dl>
	<dt>accountemail &nbsp; (string)</dt>
	<dd><strong>Required.</strong> The Email address of your Paypal Account where money shall be sent to.
  You must register this email before using the buttons.</dd>
	
	<dt>custom &nbsp; (string)</dt>
	<dd>A string of text or numbers (such as a session id) that you could use to identify this person on the returning pages.
	Paypal limits this string to a certain length, so don't make it too long (at a guess, 150 characters max).</dd>
	
	<dt>currencycode &nbsp; (string)</dt>
	<dd><strong>Required.</strong> An uppercase representation of your countries currency, abbreviated.</dd>
	
	<dt>target &nbsp; (string)</dt>
	<dd>Target Frame Name for the Paypal pages. Usually '_blank','_self','_top' . Default is the current frame or page.</dd>
	
	<dt>class &nbsp; (string)</dt>
	<dd>The name of a CSS Class style to apply directly to the &lt;input&gt; button.</dd>
	
	<dt>width &nbsp; (integer)</dt>
	<dd>Specifying a width for the button sets an inline style property of specifiec pixels. This could be accomplished with a class if inline styling isn't your thing.</dd>
	
	<dt>image &nbsp; (string)</dt>
	<dd>The full web location of an image 150px x 50px that can be displayed as a header on your Paypal pages.</dd>
	
	<dt>buttonimage &nbsp; (string)</dt>
	<dd>Full or browser relative path to an image you may want to use for the button (instead of having the standard looking buttons). If specified and the image
	doesn't exist, Internet Explorer sometimes does not display anything on the page. Be sure the image exists.</dd>
	
	<dt>buttontext &nbsp; (string)</dt>
	<dd><strong>Required.</strong> Text for the button (also sometimes displayed in IE if buttinimage isn't found).</dd>
	
	<dt>askforaddress &nbsp; (boolean)</dt>
	<dd>True or False, tells Paypal wether to ask for the customer's shipping address. Default is True.</dd>
	
	<dt>return_url &nbsp; (string)</dt>
	<dd><strong>Required.</strong> Full URL of the page users are sent to after successful payment.</dd>
	
	<dt>ipn_url &nbsp; (string)</dt>
	<dd>Full URL of the IPN page (this overrides account settings, if IPN has been setup at all). IPN must be setup within your Paypal
	account for this to work.</dd>
	
	<dt>cancel_url &nbsp; (string)</dt>
	<dd><strong>Required.</strong> Full URL of the page users are sent to if they cancel the payment process.</dd>
	
</dl>

<p><strong>Class Functions</strong></p>
<dl>
	<dt>AddItem(item_name, quantity, price[, item_no, shipping, shipping2, handling, tax, firstfieldname, firstfieldoptions, secondfieldname, secondfieldoptions])</dt>
	<dd><strong class="red">Used for One Off Payments Only</strong><br />
		<em><strong>item_name</strong> string</em> - Name or short description of the Item<br />
		<em><strong>quantity</strong> integer</em> - Quantity of this item<br />
		<em><strong>price</strong> double</em> - Price of the item, each, in whole amounts (dollars for AU, US).<br />
		<em><strong>item_no</strong> string</em> - An Item code for your reference. Not always required.<br />
		<em><strong>shipping</strong> double</em> - The cost of postage for the item, in whole amounts (dollars for AU, US).<br />
		<em><strong>shipping2</strong> double</em> - The cost of postage for each additional item, in whole amounts (dollars for AU, US). Useful when quantity is more than 1.<br />
		<em><strong>handling</strong> double</em> - The cost of packing, in whole amounts (dollars for AU, US).<br />
		<em><strong>tax</strong> double</em> - Transaction-based tax value. If present, the value passed here will override any profile VAT settings you may have (regardless of the buyer's location).<br />
		<em><strong>firstfieldname</strong> string</em> - First option field name. 64 character limit. These fields are handy for advanced carts. Example, could be 'Colour' for the item 'Shirt'.<br />
		<em><strong>firstfieldoptions</strong> string</em> - First set of option value(s). 200 character limit. Example, could be 'Red' for the field 'Colour'.<br />
		<em><strong>secondfieldname</strong> string</em> - Second option field name. 64 character limit. Example, could be 'Size' for the item 'Shirt'.<br />
		<em><strong>secondfieldoptions</strong> string</em> - Second set of option value(s). 200 character limit. Example, could be 'Medium' for the field 'Size'.
	</dd>
	
	
	<dt>AddSubscription(item_name, price[, item_no, interval, time_period, tax)</dt>
	<dd><strong class="red">Used for Subscription Payments Only</strong><br />
		<em><strong>item_name</strong> string</em> - Name or short description of the Subscription Package<br />
		<em><strong>price</strong> double</em> - Price of the Package, in whole amounts (dollars for AU, US).<br />
		<em><strong>item_no</strong> string</em> - An Item code for your reference. Not always required.<br />
		<em><strong>interval</strong> integer</em> -  Regular billing cycle. This is the length of the billing cycle.<br />
		<em><strong>time_period</strong> string</em> - Regular billing cycle units.  Acceptable values are <strong>D</strong> (days), <strong>W</strong> (weeks), <strong>M</strong> (months), <strong>Y</strong> (years).<br />
		<em><strong>tax</strong> double</em> - Transaction-based tax value. If present, the value passed here will override any profile VAT settings you may have (regardless of the buyer's location).<br />
	</dd>
	
	<dt>OutputButton()</dt>
	<dd>
		This function echo's the button to the webpage. Should be called after all other variables and functions are used.
	</dd>
	
	<dt>OutputButton()</dt>
	<dd>
		This function echo's the cancel subscription link to the webpage. Should be called after all other variables and functions are used. Refer example 4.
	</dd>
	
</dl>

<h3><a name="example1">Example 1: A Single Item Purchase</a></h3>
<div class="button">
	<?php
		require_once('paypal.inc.php');
		$button = new PayPalButton;
		$button->accountemail = 'jason@almost-anything.com.au';
		$button->custom = 'my custom passthrough variable';
		$button->currencycode = 'AUD';
		$button->class = 'paypalbutton';
		$button->buttontext = 'Purchase a Red Medium T-Shirt';
		$button->askforaddress = false;
		$button->return_url = 'http://www.jc21.com/success.php';
		$button->ipn_url = 'http://www.jc21.com/ipn.php';
		$button->cancel_url = 'http://www.jc21.com/failure.php';
	
		//Items
		$button->AddItem('T-Shirt','1','100.00','wsc001','2.00','1.00','5.00','0.00','Colour','Red','Size','Medium');							
	
		//Output		
		$button->OutputButton();
	?>
</div>
<pre style="border: 1px solid rgb(204, 204, 153); background-color: rgb(255, 255, 204);">Button Code:

1  <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/start">&lt;?php</span>
2    <span style="color: rgb(161, 161, 0);" title="php/php/keyword">require_once</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">paypal.inc.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
3    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(161, 161, 0);" title="php/php/keyword">new</span> <span style="color: rgb(153, 51, 51);" title="php/php/classname">PayPalButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
4    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">accountemail</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">jason@almost-anything.com.au</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
5    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">custom</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">my custom passthrough variable</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
6    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">currencycode</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">AUD</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
7    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">class</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">paypalbutton</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
8    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">buttontext</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Purchase a Red Medium T-Shirt</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
9    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">askforaddress</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/constant">false</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
10   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">return_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.jc21.com/success.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
11   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">ipn_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.jc21.com/ipn.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
12   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">cancel_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.jc21.com/failure.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
13   <span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment/start">//</span><span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment">Items</span>
14   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">AddItem</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">T-Shirt</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">1</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">100.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">wsc001</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">2.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">1.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">5.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">0.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Colour</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Red</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Size</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Medium</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
15   <span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment/start">//</span><span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment">Output		</span>
16   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">OutputButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
17 <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/end">?&gt;</span>
</pre>


<h3><a name="example2">Example 2: A Multiple Item Purchase (shopping cart)</a></h3>
<div class="button">
<?php
  require_once('paypal.inc.php');
  $button = new PayPalButton;
  $button->accountemail = 'jason@almost-anything.com.au';
  $button->custom = 'my custom passthrough variable';
  $button->currencycode = 'AUD';
  $button->buttontext = 'Purchase Some Items';
  $button->return_url = 'http://www.jc21.com/success.php';
  $button->ipn_url = 'http://www.jc21.com/ipn.php';
  $button->cancel_url = 'http://www.jc21.com/failure.php';
  //Items
  $button->AddItem('T-Shirt','1','100.00','wsc001','2.00','1.00','5.00','0.00','Colour','Red','Size','Medium');							
  $button->AddItem('Sports Cap','1','10.00','wsc002');
  $button->AddItem('Umbrella','1','120.00','wsc003','','','','0.00');
  $button->AddItem('Book','3','110.00','wsc004','10.00');
  //Output				
  $button->OutputButton();
?>
</div>

<pre style="border: 1px solid rgb(204, 204, 153); background-color: rgb(255, 255, 204);">1  <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/start">&lt;?php</span>
2    <span style="color: rgb(161, 161, 0);" title="php/php/keyword">require_once</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">paypal.inc.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
3    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(161, 161, 0);" title="php/php/keyword">new</span> <span style="color: rgb(153, 51, 51);" title="php/php/classname">PayPalButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
4    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">accountemail</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">jason@almost-anything.com.au</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
5    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">custom</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">my custom passthrough variable</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
6    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">currencycode</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">AUD</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
7    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">buttontext</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Purchase Some Items</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
8    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">return_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.jc21.com/success.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
9    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">ipn_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.jc21.com/ipn.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
10   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">cancel_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.jc21.com/failure.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
11   <span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment/start">//</span><span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment">Items</span>
12   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">AddItem</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">T-Shirt</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">1</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">100.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">wsc001</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">2.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">1.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">5.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">0.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Colour</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Red</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Size</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Medium</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>							
13   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">AddItem</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Sports Cap</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">1</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">10.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">wsc002</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
14   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">AddItem</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Umbrella</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">1</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">120.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">wsc003</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">0.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
15   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">AddItem</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Book</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">3</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">110.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">wsc004</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">10.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
16   <span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment/start">//</span><span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment">Output				</span>
17   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">OutputButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
18 <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/end">?&gt;</span></pre>





<h3><a name="example3">Example 3: Subscription Button</a></h3>

<p>For this button, transactions are made every 56 days:</p>
<div class="button">
<?php
	require_once('paypal.inc.php');
  $button = new PayPalButton;
  $button->accountemail = 'jason@almost-anything.com.au';
  $button->custom = 'my custom passthrough variable';
  $button->currencycode = 'AUD';
  $button->buttontext = 'Subscribe';
  $button->askforaddress = false;
  $button->return_url = 'http://www.almost-anything.com.au/index.php';
  $button->ipn_url = 'http://www.almost-anything.com.au/index.php';
  $button->cancel_url = 'http://www.almost-anything.com.au/index.php';
  //Subscriptions
  $button->AddSubscription('My Subscription','10.00','SUB100',56,'D');
  //Output
  $button->OutputButton();
?>
</div>


<pre style="border: 1px solid rgb(204, 204, 153); background-color: rgb(255, 255, 204);">1  <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/start">&lt;?php</span>
2    <span style="color: rgb(161, 161, 0);" title="php/php/keyword">require_once</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">paypal.inc.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
3    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(161, 161, 0);" title="php/php/keyword">new</span> <span style="color: rgb(153, 51, 51);" title="php/php/classname">PayPalButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
4    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">accountemail</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">jason@almost-anything.com.au</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
5    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">custom</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">my custom passthrough variable</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
6    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">currencycode</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">AUD</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
7    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">buttontext</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Subscribe</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
8    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">askforaddress</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/constant">false</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
9    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">return_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.almost-anything.com.au/index.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
10   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">ipn_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.almost-anything.com.au/index.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
11   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">cancel_url</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">http://www.almost-anything.com.au/index.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
12   <span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment/start">//</span><span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment">Subscriptions</span>
13   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">AddSubscription</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">My Subscription</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">10.00</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">SUB100</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(17, 17, 238);" title="php/php/num/int">56</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">,</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">D</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
14   <span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment/start">//</span><span style="color: rgb(136, 136, 136); font-style: italic;" title="php/php/single_comment">Output</span>
15   <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">button</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">OutputButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
16 <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/end">?&gt;</span></pre>



<h3><a name="example4">Example 4: Cancel Subscription Link</h2>
<div class="button">
<?php
	require_once('paypal.inc.php');
  $cancellink = new PayPalButton;
  $cancellink->accountemail = 'jason@almost-anything.com.au';
  $cancellink->width = '150';
  $cancellink->buttontext = 'Cancel Subscription';
  $cancellink->OutputSubscriptionCancel();	
?>
</div>

<pre style="border: 1px solid rgb(204, 204, 153); background-color: rgb(255, 255, 204);">1  <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/start">&lt;?php</span>
2    <span style="color: rgb(161, 161, 0);" title="php/php/keyword">require_once</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">paypal.inc.php</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
3    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">cancellink</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(161, 161, 0);" title="php/php/keyword">new</span> <span style="color: rgb(153, 51, 51);" title="php/php/classname">PayPalButton</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
4    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">cancellink</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">accountemail</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">jason@almost-anything.com.au</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
5    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">cancellink</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">width</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">150</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
6    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">cancellink</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">buttontext</span> <span style="color: rgb(0, 128, 0);" title="php/php/symbol">=</span> <span style="color: rgb(255, 0, 0);" title="php/php/single_string/start">'</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string">Cancel Subscription</span><span style="color: rgb(255, 0, 0);" title="php/php/single_string/end">'</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>
7    <span style="color: rgb(51, 51, 255);" title="php/php/varstart">$</span><span style="color: rgb(51, 51, 255);" title="php/php/var">cancellink</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">-&gt;</span><span style="color: rgb(153, 51, 51);" title="php/php/oodynamic">OutputSubscriptionCancel</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">(</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">)</span><span style="color: rgb(0, 128, 0);" title="php/php/symbol">;</span>	
8  <span style="font-weight: bold; color: rgb(0, 0, 0);" title="php/php/end">?&gt;</span></pre>
</body>
</html>
