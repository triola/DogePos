<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");


//take logged in users to account page
if(isUserLoggedIn()) { 
	echo "<script>window.location.replace('account.php');</script>";  }
else {
	echo "<script>window.location.replace('login.php');</script>"; 
 }

?>

<div id='main'>

</div>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>


