<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
require_once("models/cryptofunctions.php");



if ($_POST['submit'] == "Withdraw Doge"){
	if ($_POST['withdrawdogeamount'] > get_balance($loggedInUser->user_id, "DOGE")) {
		$error = "You cannot withdraw more than you have!";
	}
	$result = withdraw($loggedInUser->user_id, 'doge', $_POST['withdrawdogeamount']);
} else if ($_POST['submit'] == "Withdraw BTC"){
	if ($_POST['withdrawbtcamount'] > get_balance($loggedInUser->user_id, "BTC")) {
		$error = "You cannot withdraw more than you have!";
	}
	$result = withdraw($loggedInUser->user_id, 'btc', $_POST['withdrawbtcamount']);
} else {
}

?>

<div class='container container_12'>
	<?php if($result) {?><div class="notice">Withdraw succeeded with transaction id: <?php echo $result;?></div><?php } else if ($error) {?>
		<div class="error">Error: <?php echo $error;?></div><?php }
	?>
	<div class="grid_5 push_1 box grid_box">
		<div class="balance">DOGE Balance: <?php echo get_balance($loggedInUser->user_id, "DOGE");?></div>
		<label for="dogeamount">Withdraw to: <span class="fineprint">(<?php echo $loggedInUser->dogeaddress;?>)</span></label>
		<form action=' <?php echo $_SERVER['PHP_SELF']; ?>' method="post">
			<input type="text" name="withdrawdogeamount" placeholder="amount" id="dogeamount">
			<input type="submit" name="submit" class="btn small" value="Withdraw Doge">
		</form>
	</div>
	<div class="grid_5 push_1 box grid_box">
		<div class="balance">BTC Balance: <?php echo get_balance($loggedInUser->user_id, "BTC");?></div>
		<label for="btcamount">Withdraw to: <span class="fineprint">(<?php echo $loggedInUser->btcaddress;?>)</span></label>
		<form action=' <?php echo $_SERVER['PHP_SELF']; ?>' method="post">
			<input type="text" name="withdrawbtcamount" placeholder="amount" id="btcamount">
			<input type="submit" name="submit" class="btn small" value="Withdraw BTC">
		</form>
	</div>
	<div class="grid_10 push_1 box grid_box">
		<div class="left"><h2>Doge Transactions</h2>
			<?php //withdraw($loggedInUser->user_id, 4153, 'btc', .001); ?>
			<?php get_transactions($loggedInUser->user_id, 'DOGE', 0, 'afdt'); ?>
		</div>
		<div class="right"><h2>BTC Transactions</h2>
			<?php get_transactions($loggedInUser->user_id, 'BTC', 0, 'afdt'); ?>
		</div>
		
	
	</div>
</div>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>
