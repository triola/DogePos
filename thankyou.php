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


<div class='grid_8 push_2 box'>
	<h1>Thank you!</h1>
	<p>Thanks for signing up - we'll be taking on new businesses every day, so we hope to reach you soon. In the meantime, you can get in touch with us at <a href="http://twitter.com/DogePos">@DogePos</a>.</p>
	</form>
</div>
</div>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>



