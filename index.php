<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<div class="showcase">
	<div class="container_12">
		<div class="grid_5">
		<h1>Start <br>Accepting<span>Bitcoin and Dogecoin in your <br>retail store or restaurant.</span></h1>
		</div>
	</div>
</div>
<div class="signup"><div class="signupbg">
	<div class="container_12">
		<div class="grid_2 envelope"><i class="fa fa-asterisk beta-signup"></i></div>
		<div class="grid_5"><h2>Public Beta</h2><p>DogePos is currently in an open public beta. We are looking for eager store owners who are willing to help us make DogPos a great piece of software.</p></div>
		<div class="grid_5 requestinvite"><a class="mailchimp btn fancybox" href="/register.php" target="_blank">Get Started<i class="fa fa-chevron-right"></i></a></div>
	</div>
	<br class="clear" />
</div></div>

<div class="container_12">
	<div class="grid_4 feature">
		<i class="fa fa-cogs"></i>
		<h3>Web Based</h3>
		<p>Works on mobile devices, even iOS.</p>
	</div>
	<div class="grid_4 feature">
		<i class="fa fa-check"></i>
		<h3>Instant Verification</h3>
		<p>Keep the line moving. Get notified of successful payments in seconds.</p>
	</div>
	<div class="grid_4 feature">
		<i class="fa fa-moon-o"></i>
		<h3>Nightly Deposits</h3>
		<p>Automatic nightly deposits, manual deposits anytime.</p>
	</div><br class="clear">
</div>
<div class="demo">
	<div class="container_12">
		<div class="grid_5 ipad"><img src="images/ipad.png"></div>
		<div class="grid_7">
			<h2>See it in action</h2>
			<p>DogePos is still in the prototype phase, but our demo will give you an idea of how it works, and the basic flow you can expect.</p>
			<a href="/demo-pos.php" class="btn">See the demo</a><br>
			<p>Or see it in person at <a href="http://strangedonuts.com">Strange Donuts</a>.</p>
		</div>
	</div>
	<br class="clear" />
</div>


<footer class="marketing">
Get involved: Tweet at <a href="http://twitter.com/dogepos">@DogePos</a>, or donate to help development: DPgKdeXG1w2R5qxJcxZcuNxHKCRBwkgMZh
</footer><?php include("footer.php");?>


