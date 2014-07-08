<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
if(isUserLoggedIn()){
	if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(3)) ){
	} else {
		echo "<script>window.location.replace('newaccount.php');</script>"; 
	}
}
?>

<div class='container container_12 choose'>
	<div class="grid_10 push_1 box">
	<p class="fineprint" style="text-align:center; font-size:1.2em;">Public Demo</p>

	<a href="/demo-doge.php" class="left coin"><img src="/images/dogecoin.png"></a>
	<a href="/demo-btc.php" class="right coin"><img src="/images/bitcoin.png"></a>
	
		<!-- <p>Hey, <?php echo $loggedInUser->displayname; ?> This is an example secure page designed to demonstrate some of the basic features of UserCake. Just so you know, your title at the moment is <?php echo $loggedInUser->title; ?>, and that can be changed in the admin panel. You registered this account on <?php echo date("M d, Y", $loggedInUser->signupTimeStamp()); ?>.</p> -->
	</div>
</div>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>