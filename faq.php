<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
//if(isUserLoggedIn()) { header("Location: account.php"); die(); }


require_once("models/header.php");
?>



<div class="container container_12">

<?php echo resultBlock($errors,$successes); ?>


<div class='grid_12 contentwrap'>
<article>
	<h1>FAQ</h1>
	<dl>
		<dt>Is there a startup cost?</dt>
		<dd>Because DogePos is web based, there is no hardware to buy, and no setup costs.</dd>
		
		<dt>What about a fee?</dt>
		<dd>There are no monthly fees.
Eventually our transaction fee will be 1%. Right now, during our private beta, there is 0 transaction fee.</dd>

		<dt>Where does my money go?</dt>
		<dd>When you process a transaction, your cryptocurrency is stored in our secure wallet in an account just for you. You can withdraw your money at any time.</dd>
		
		<dt>Can I withdraw direct to fiat/USD?</dt>
		<dd>Soon. We are working on a solution to allow users to cash out via Vault of Satoshi.</dd>
		
		<dt>What about security?</dt>
		<dd>Our site is SSL encrypted, with many security checks in place. Our wallet is on a separate server and not directly accessible from the internet. Our servers are hosted off site with a very reputable hosting company.</dd>
	
		<dt>Are you a real company?</dt>
		<dd>Yes! We are a real company, with real people working every day to make DogePos better. We aren’t some faceless online pseudonym - we exist, and we’re staking our reputation on DogePos.</dd>
			
		<dt>Where are you located?</dt>
		<dd>We’re located in St. Louis, Missouri, in the U.S. We share an office with Rampant Interactive, a partner company. Our address is 3101A Sutton Blvd. We like visitors - set up an appointment to come see us!</dd>
	</dl><br>
	<p class="textcenter">Such question. Many answer. So frequent.</p>
</article>
</div>
</div>
<div id='bottom'></div>
<footer class="marketing">
Get involved: Tweet at <a href="http://twitter.com/dogepos">@DogePos</a>, or donate to help development: DPgKdeXG1w2R5qxJcxZcuNxHKCRBwkgMZh
</footer>
</div>
<?php include("footer.php");?>



