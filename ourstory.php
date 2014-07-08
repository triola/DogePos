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
	<h1>Our Story</h1>
	<blockquote>"It all started with donuts"</blockquote>
	<p><img class="right" src="images/dones.jpg" width="400">DogePos was born when a local donut shop (<a href="http://strangedonuts.com">Strange Donuts</a>) asked about Dogecoin. After explaining it to the owner, he immediately said "I want to accept it - can you help me?" In two weeks we had a working prototype, and Strange Donuts took Doge for the first time at their store.</p>

<p>We weren't prepared for the amount of attention and excitement that came from that first transaction. Being able to spend Dogecoin in a physical place for tangible goods legitimizes our currency, and really gets people pumped about Dogecoin. It's that excitement that brought us to the decision to share DogePos with the world.</p>

<p>The best way we can help the community is the way that comes most natural to us - we want to work with businesses to help them understand doge, get involved, and accept doge for their goods and services. We also want to encourage them to donate a portion of their doge sales to charity, and we plan to set an example by doing this ourselves once we begin to collect fees.</p>
<p>
<em>Really it doesn't matter if a business wants to use DogePos or not - we want to help them get engaged with the community, and accept Dogecoin.</em></p>
</article>
</div>
</div>
<div id='bottom'></div>
<footer class="marketing">
Get involved: Tweet at <a href="http://twitter.com/dogepos">@DogePos</a>, or donate to help development: DPgKdeXG1w2R5qxJcxZcuNxHKCRBwkgMZh
</footer>
</div>
<?php include("footer.php");?>

