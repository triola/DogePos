<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }



if(!empty($_POST))
{
	$errors = array();
	$successes = array();
	$pin = sanitize($_POST["pin"]);
	$password = $_POST["password"];
	$password_new = $_POST["passwordc"];
	$password_confirm = $_POST["passwordcheck"];
	$dogeaddress = $_POST["dogeaddress"];
	$autodoge = $_POST["autodoge"];
	$btcaddress = $_POST["btcaddress"];
	$autobtc = $_POST["autobtc"];
	$currency = $_POST["currency"];
	
	if ($autodoge == "on"){
		$autodoge = 1;
	}
	if ($autobtc == "on"){
		$autobtc = 1;
	}
	
	
	$errors = array();
	$email = sanitize($_POST["email"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	
	
	
	//Confirm the hashes match before updating a users password
	$entered_pass = generateHash($password,$loggedInUser->hash_pw);
	
	if (trim($password) == ""){
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}
	else if($entered_pass != $loggedInUser->hash_pw)
	{
		//No match
		$errors[] = lang("ACCOUNT_PASSWORD_INVALID");
	}	
	if($email != $loggedInUser->email)
	{
		if(trim($email) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
		}
		else if(!isValidEmail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		else if(emailExists($email))
		{
			$errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));	
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			$loggedInUser->updateEmail($email);
			$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
		}
	}
	
	//Update Currency
	if ($currency != $loggedInUser->currency && count($errors) == 0){
		$loggedInUser->updateCurrency($currency);
		$successes[] = "currency updated";

	}
	
	//update withraw addresses
	if($autodoge != $loggedInUser->autodoge || $autobtc != $loggedInUser->autobtc || $dogeaddress != $loggedInUser->dogeaddress || $btcaddress != $loggedInUser->btcaddress){

		$check = "TRIGGERED";
		//check pin
		$userdetails = fetchUserDetails(NULL,NULL,$loggedInUser->user_id);
		$entered_pin = generateHash($pin,$userdetails["pin"]);
		if($entered_pin != $userdetails["pin"]) {
			$errors[] = "wrong pin!";
		}
		
	//update doge address
	if($dogeaddress != $loggedInUser->dogeaddress)
	{
		if(trim($dogeaddress) == "")
		{
			$errors[] = "error";
		}
		
		//End data validation
		
		if(count($errors) == 0)
		{
			$loggedInUser->updateDogeaddress($dogeaddress);
			$successes[] = "address updated";
		}
	}
	
		//update btc address
	if($btcaddress != $loggedInUser->btcaddress)
	{
		if(trim($btcaddress) == "")
		{
			$errors[] = "error";
		}
	
		//End data validation
		
		if(count($errors) == 0)
		{
			$loggedInUser->updateBtcaddress($btcaddress);
			$successes[] = "address updated";
		}
	}
		//update auto doge
	if($autodoge != $loggedInUser->autodoge)
	{
		if(count($errors) == 0)
		{
			$loggedInUser->updateAutoDoge($autodoge);
			$successes[] = "autodoge updated";
		}
	}
		//update auto btc
	if($autobtc != $loggedInUser->autobtc)
	{
		
		if(count($errors) == 0)
		{
			$loggedInUser->updateAutoBtc($autobtc);
			$successes[] = "autobtc updated";
		}
	}
	
  }
	
	if ($password_new != "" OR $password_confirm != "")
	{
		if(trim($password_new) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
		}
		else if(trim($password_confirm) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
		}
		else if(minMaxRange(8,50,$password_new))
		{	
			$errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
		}
		else if($password_new != $password_confirm)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//Also prevent updating if someone attempts to update with the same password
			$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
			
			if($entered_pass_new == $loggedInUser->hash_pw)
			{
				//Don't update, this fool is trying to update with the same password Â¬Â¬
				$errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
			}
			else
			{
				//This function will create the new hash and update the hash_pw property.
				$loggedInUser->updatePassword($password_new);
				$successes[] = lang("ACCOUNT_PASSWORD_UPDATED");
			}
		}
	}
	if(count($errors) == 0 AND count($successes) == 0){
		$errors[] = lang("NOTHING_TO_UPDATE");
	}
}

require_once("models/header.php");

?>

<div class='container container_12'>
	<div class="grid_10 push_1 box regbox settings">

		<?php echo resultBlock($errors,$successes);?>

		<div>
			<form name='updateAccount' action=' <?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
				<h1>User Info</h1>
				<p>
					<label>Password:</label>
					<input type='password' name='password' />
				</p>
				<p>
					<label>Fiat Currency:</label>
					<select name="currency">
						<option selected="selected" value="<?php echo $loggedInUser->currency;?>">*<?php echo $loggedInUser->currency;?>*</option>
						<option value="AUD">AUD</option>
						<option value="CAD">CAD</option>
						<option value="EUR">EUR</option>
						<option value="GBP">GBP</option>
						<option value="USD">USD</option>
						<option value="YEN">YEN</option>
					</select>
				</p>
				<p>
					<label>Email:</label>
					<input type='text' name='email' value='<?php echo $loggedInUser->email;?>' />
				</p>
				<p>
					<label>New Pass:</label>
					<input type='password' name='passwordc' />
					</p>
				<p>
					<label>Confirm Pass:</label>
					<input type='password' name='passwordcheck' />
				</p>
				<hr>
				<h1>Withdraw</h1>
				<p> These require PIN entry:<bR><br>
					<label>PIN:</label>
					<input type='password' name='pin' value='' />
				</p>
				<p>
					<label>Doge Withdraw Address:</label>
					<input type='text' name='dogeaddress' value='<?php echo $loggedInUser->dogeaddress;?>' />
					<label>Auto Withdraw Doge?</label><input type="checkbox" <?php if ($loggedInUser->autodoge){ echo "checked='checked'";}?> name="autodoge">
				</p>
				<p>
					<label>BTC Withdraw Address:</label>
					<input type='text' name='btcaddress' value='<?php echo $loggedInUser->btcaddress;?>'/>
					<label>Auto Withdraw BTC?</label><input type="checkbox" <?php if ($loggedInUser->autobtc){ echo "checked='checked'";}?>  name="autobtc">
				</p>
				<p>
					<label>&nbsp;</label>
					<input type='submit' value='Update' class='submit' />
				</p>
			</form>
		</div>
	</div>
</div>	
<?php include("footer.php");?>
