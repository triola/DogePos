<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

class loggedInUser {
	public $email = NULL;
	public $hash_pw = NULL;
	public $user_id = NULL;
	public $currency = NULL;
	public $remember_me = NULL;
	public $dogeaddress = NULL;
	public $btcaddress = NULL;
	public $autodoge = NULL;
	public $autobtc = NULL;
	
	//Simple function to update the last sign in of a user
	public function updateLastSignIn()
	{
		global $mysqli,$db_table_prefix;
		$time = time();
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET
			last_sign_in_stamp = ?
			WHERE
			id = ?");
		$stmt->bind_param("ii", $time, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Return the timestamp when the user registered
	public function signupTimeStamp()
	{
		global $mysqli,$db_table_prefix;
		
		$stmt = $mysqli->prepare("SELECT sign_up_stamp
			FROM ".$db_table_prefix."users
			WHERE id = ?");
		$stmt->bind_param("i", $this->user_id);
		$stmt->execute();
		$stmt->bind_result($timestamp);
		$stmt->fetch();
		$stmt->close();
		return ($timestamp);
	}
	
	//Update a users password
	public function updatePassword($pass)
	{
		global $mysqli,$db_table_prefix;
		$secure_pass = generateHash($pass);
		$this->hash_pw = $secure_pass;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET
			password = ? 
			WHERE
			id = ?");
		$stmt->bind_param("si", $secure_pass, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Update a users email
	public function updateEmail($email)
	{
		global $mysqli,$db_table_prefix;
		$this->email = $email;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET 
			email = ?
			WHERE
			id = ?");
		$stmt->bind_param("si", $email, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Update a users currency
	public function updateCurrency($currency)
	{
		global $mysqli,$db_table_prefix;
		$this->currency = $currency;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET 
			currency = ?
			WHERE
			id = ?");
		$stmt->bind_param("si", $currency, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Update a users dogeaddress
	public function updateDogeaddress($dogeaddress)
	{
		global $mysqli,$db_table_prefix;
		$this->dogeaddress = $dogeaddress;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET 
			dogeaddress = ?
			WHERE
			id = ?");
		$stmt->bind_param("si", $dogeaddress, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Update a users btcaddress
	public function updateBtcaddress($btcaddress)
	{
		global $mysqli,$db_table_prefix;
		$this->btcaddress = $btcaddress;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET 
			btcaddress = ?
			WHERE
			id = ?");
		$stmt->bind_param("si", $btcaddress, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Update auto doge
	public function updateAutoDoge($auto)
	{	
		echo $auto;
		if ($auto == true || $auto == on){
			$auto = 1;
		}
		else {
			$auto = 0;
		}
		global $mysqli,$db_table_prefix;
		$this->autodoge = $auto;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET 
			autodoge = ?
			WHERE
			id = ?");
		$stmt->bind_param("ii", $auto, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//Update auto doge
	public function updateAutoBtc($auto)
	{	
		if ($auto == true || $auto == 'on'){
			$auto = 1;
		}
		else {
			$auto = 0;
		}
		global $mysqli,$db_table_prefix;
		$this->autobtc = $auto;
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
			SET 
			autobtc = ?
			WHERE
			id = ?");
		$stmt->bind_param("ii", $auto, $this->user_id);
		$stmt->execute();
		$stmt->close();	
	}
	
	//get currency symbol
	public function currencySymbol(){
		
		switch ($this->currency) {
		case "AUD":
			$s = "$";
			break;
		case "CAD":
			$s = "$";
			break;
		case "EUR":
			$s = "&euro;";
			break;
		case "GBP":
			$s = "&pound;";
			break;
		case "USD":
			$s = "$";
			break;
		case "YEN":
			$s = "&yen;";
			break;
		}
		return $s;
	}
	
	
	//Is a user has a permission
	public function checkPermission($permission)
	{
		global $mysqli,$db_table_prefix,$master_account;
		
		//Grant access if master user
		
		$stmt = $mysqli->prepare("SELECT id 
			FROM ".$db_table_prefix."user_permission_matches
			WHERE user_id = ?
			AND permission_id = ?
			LIMIT 1
			");
		$access = 0;
		foreach($permission as $check){
			if ($access == 0){
				$stmt->bind_param("ii", $this->user_id, $check);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows > 0){
					$access = 1;
				}
			}
		}
		if ($access == 1)
		{
			return true;
		}
		if ($this->user_id == $master_account){
			return true;	
		}
		else
		{
			return false;	
		}
		$stmt->close();
	}
	
	//Logout
	public function userLogOut()
	{
		destroySession("userCakeUser");
	}	
}

?>