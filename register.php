<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){ die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST)) 
{
	$errors = array();
	$email = trim($_POST["email"]);
	$username = trim($_POST["username"]);
	$displayname = trim($_POST["displayname"]);
	$password = trim($_POST["password"]);
	$location = trim($_POST["location"]);
	$about = trim($_POST["about"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$pin = trim($_POST["pin"]);
	$captcha = md5($_POST["captcha"]);
		
	
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	if(minMaxRange(5,25,$username))
	{
		$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($username)){
		$errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
	}
	if(minMaxRange(5,25,$displayname))
	{
		$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($displayname)){
		//$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
	}
	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$user = new User($username,$displayname,$password,$email,$pin,$location,$about);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
			if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
		}
		else
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
	}
}

require_once("models/header.php"); 
?>



<?php if ($errors != null || $successes == null){

echo resultBlock($errors,$successes); ?>

<div class='container container_12'>
	<div class="grid_10 push_1 box regbox">
<form name='newUser' action='<?php echo $_SERVER['PHP_SELF']."?reg=submitted"; ?>' method='post'>
<div class="left">
<p>
<label>User Name:</label>
<input type='text' name='username' value="<?php echo $_POST['username'];?>" />
</p>
<p>
<label>Business Name:</label>
<input type='text' name='displayname' value="<?php echo $_POST['displayname'];?>" />
</p>
<p>
<label>Location:</label>
<input type='text' name='location' value="<?php echo $_POST['location'];?>" />
</p>
<p>
<label>Password:</label>
<input type='password' name='password' />
</p>
<p>
<label>Confirm:</label>
<input type='password' name='passwordc' />
</p>
</div>
<div class="right">
<label>PIN (don't forget this!):</label>
<input type='password' name='pin' />
</p>
<p>
<label>Email:</label>
<input type='text' name='email' value="<?php echo $_POST['email'];?>"/>
</p>
<p>
<label>Security Code:</label>
<div class="codecontainer"><img class="securitycode" src='models/captcha.php'></div> 
</p>
<label>Enter Security Code:</label>
<input name='captcha' type='text'>
</p>
<p>
<label>About your business:</label>
<textarea name='about' rows="3" ><?php echo $_POST['about'];?></textarea>
</p>
</div>
<label>&nbsp;<br class="clear">
<input type='submit' value='Register'/>
</p>

</form>
</div>

</div>

<?php } else { ?>

<div class='container container_12'>
	<div class="grid_10 push_1 box regbox">
	<?php echo resultBlock($errors,$successes); ?><br>
	<h2><a href="login.php">Login now -></a></h2>
	</div>
</div>


<?php } ?>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>



