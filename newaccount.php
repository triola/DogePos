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
	<h1>Welcome!</h1>
	<p>If you're seeing this page, it's because you've registered, and I haven't activated your account yet. DogePos is currently in closed beta allowing just a few new users at a time. Just hang tight, and we'll be in touch with you soon. -<a href="http://twitter.com/bentriola">@BenTriola</a>.</p>
	</form>
</div>
</div>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>



