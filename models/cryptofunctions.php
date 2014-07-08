<?php //crypto specific transactions

require_once("funcs.php");

function log_transaction($address, $amount, $fiat, $fiatcurrency="USD", $currency, $user, $transactionid){
	global $mysqli,$db_table_prefix,$errors; 
	
	$stmtlog = $mysqli->prepare("INSERT INTO ".$db_table_prefix."transactions (userid, currency, amount, fiat, fiatcurrency, receiving_address, timestamp, transactionid) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	
    $stmtlog->bind_param("isddssis", $user, $currency, $amount, $fiat, $fiatcurrency, $address, time(), $transactionid);
    $stmtlog->execute();
    $insertid = $stmtlog->insert_id;
    $stmtlog->close();			
    
    return $insertid;
}

function log_purchase($transid, $first, $last, $address, $address2, $city, $state, $zip, $phone, $email){
	global $mysqli,$db_table_prefix,$errors; 
	
	$stmtlog = $mysqli->prepare("INSERT INTO ".$db_table_prefix."customer_info (transaction_id, first, last, address, address2, city, state, zip, phone, email) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	
    $stmtlog->bind_param("isssssssss", $transid, $first, $last, $address, $address2, $city, $state, $zip, $phone, $email);
    $stmtlog->execute();
    $insertid = $stmtlog->insert_id;
    $stmtlog->close();			
    
    return $insertid;
}


function get_transactions($user, $currency = "all", $count, $format="ucafdrst"){
	global $mysqli,$db_table_prefix,$errors; 
	
	$format = str_split($format);

	if ($currency != "all"){
		$args .= " and currency = '".$currency."'";
	}
	if ($count > 0){
		$args .= " limit = ".$count;
	}
	
	
	$query = "Select userid, currency, amount, fiatcurrency, fiat, receiving_address, sending_address, timestamp from uc_transactions where userid = '$user'". $args . " order by timestamp DESC";
	
	
	//Retrieve address balance
	$stmt = $mysqli->prepare($query);	
	$stmt->execute();
	$stmt->bind_result($userid, $currency, $amount, $fiatcurrency, $fiat, $receiving_address, $sending_address, $timestamp);
	
	echo "<table>";
	while ($stmt->fetch()){
		echo "<tr>";
		$transaction = array('u' => $userid, 'c' => $currency, 'a' => $amount, 'f' => $fiatcurrency, 'd' => $fiat, 'r' => $receiving_address, 's' => $sending_address, 't' => $timestamp );
		
		foreach ($format as $x){
			if ($x == 't'){
				$transaction[$x] = date('m/d/Y', $transaction[$x]);
			}
			if ($x == 'f'){
				$transaction[$x] = currencySymbol($transaction[$x]);
			}
			if ($x == 'd'){
				$transaction[$x] = number_format((float)$transaction[$x], 2, '.', '');;
			}
			echo "<td>".$transaction[$x]."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	
	$stmt->close();
}

function get_balance($userid,$currency) {
	global $handshake;
	global $dogeWalletServer;
	global $btcWalletServer;

	//hit api to get balance
	$account = "dogepos-".$userid;


	$key = $account.$handshake;
	$key = sha1($key);
	
	if (strtoupper($currency) == "DOGE"){
		$url = 	$dogeWalletServer . 'index.php?call=getbalancebyaccount&params='.$account.'&key='.$key;
	} else if (strtoupper($currency) == "BTC"){
		$url = 	$btcWalletServer . 'index.php?call=getbalancebyaccount&params='.$account.'&key='.$key;
	}

	//open connection
	$ch = curl_init();
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	//execute post
	$result = curl_exec($ch);
	//close connection
	curl_close($ch);

	return $result;
}

function withdraw($userid,$currency,$amount, $address=NULL, $fiatcurrency="USD"){
	global $handshake;
	global $dogeWalletServer;
	global $btcWalletServer;

	if ($address == NULL){
			$userdetails = fetchUserDetails(NULL,NULL,$userid);
			$address = $userdetails[$currency.'address'];
		}
	$params = $address . '@@@' . $amount . '@@@' . 'dogepos-'.$userid;
					
	$key = $params.$handshake;
	$key = sha1($key);
	

	if (strtoupper($currency) == "DOGE"){
		//generate api call
		$url = $dogeWalletServer . 'index.php?call=withdraw&params='.$params.'&key='.$key;
		//do conversion
		$fiat = get_doge_conversion($amount, $fiatcurrency, true);
	} else if (strtoupper($currency) == "BTC"){
		$url = $btcWalletServer . 'index.php?call=withdraw&params='.$params.'&key='.$key;
		//do conversion
		$fiat = get_btc_conversion($amount, $fiatcurrency, true);
	}
	
	echo "[fiat=".$fiat.$fiatcurrency." || amount=".$amount.$currency;

	echo $url;
	
		
//open connection
$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		//execute post
		$result = curl_exec($ch);
		
		//print_r($result);
		
		if (strlen($result) > 20){
			$logamount = 0 - $amount;
			$logfiat = 0 - $fiat;
			log_transaction($address, $logamount, $logfiat, $fiatcurrency, strtoupper($currency), $userid, $result);
		}
		
		//close connection
		curl_close($ch);
		
		//echo "result".$result;
		
		return $result;


	/* part of pin check
	}
	*/
	
	
}

function get_doge_conversion($amount, $currency='USD', $reverse=false) {
	global $mysqli,$db_table_prefix,$errors; 

	$url = 	'http://pubapi.cryptsy.com/api.php?method=singlemarketdata&marketid=132';
	//open connection
	$ch = curl_init();
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	
		$data = json_decode($result);
		$dogetobtc = $data->return->markets->DOGE->lasttradeprice;
		if ($dogetobtc) {
			$return .= $dogetobtc;
		}
		else {
		$stmt = $mysqli->prepare("SELECT dogetobtc
		FROM doge_price limit 1");	
		$stmt->execute();		
		$stmt->bind_result($historicDoge);

		$stmt->fetch();
		$stmt->close();
		
		$dogetobtc = $historicDoge;
		
		$return .= number_format($historicDoge, 8, '.', '');
	
		}
		
		if($_GET['satoshis'] == true){
			printf( $return * 100000000 );
			//echo "3";
			break;
		}
	
	
	$url = 	'https://coinbase.com/api/v1/prices/spot_rate?currency='.$currency;


	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);	

	$data = json_decode($result);
	$return .="@@@@";
	$btctodollars = $data->amount;
	if ($btctodollars){
		$return .= $btctodollars;
	} else {
		$stmt = $mysqli->prepare("SELECT btctodollars
		FROM doge_price limit 1");	
		$stmt->execute();		
		$stmt->bind_result($historicBTC);

		$stmt->fetch();
		$stmt->close();
		
		$btctodollars = $historicBTC;
		
		$return .= number_format($historicBTC, 8, '.', '');
	
		}

	$url = "http://dogechain.info/chain/Dogecoin/q/totalbc";
	
	//printf($return);
	
	if ($reverse){
		$math = $amount * ($dogetobtc * $btctodollars);	
	} else {
		$math = $amount / ($dogetobtc * $btctodollars);	
	}
	
	curl_close($ch);

if ($dogetobtc && $btctodollars) {
	$store = $mysqli->query("UPDATE doge_price SET dogetobtc = $dogetobtc, btctodollars = $btctodollars where id = 1");	
}
	return $math;

}


function get_btc_conversion($amount, $currency='USD', $reverse=false){
	global $mysqli,$db_table_prefix,$errors; 

	$ch = curl_init();

	$url = 	'https://coinbase.com/api/v1/prices/spot_rate?currency='.$currency;
		

	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);	
	

	$data = json_decode($result);
	$return .="@@@@";
	$btctodollars = $data->amount;
	if ($btctodollars){
		$return .= $btctodollars;
	} 
	else {
		$stmt = $mysqli->prepare("SELECT btctodollars
		FROM doge_price limit 1");	
		$stmt->execute();		
		$stmt->bind_result($historicBTC);

		$stmt->fetch();
		$stmt->close();
		
		$btctodollars = $historicBTC;
		$return .= $historicBTC;
	
		}
	
	//printf($return);
	if ($reverse){
	$math = $amount * $btctodollars;
	} else {
	$math = $amount / $btctodollars;
	}
	
	curl_close($ch);

if ($btctodollars) {
	$store = $mysqli->query("UPDATE doge_price SET btctodollars = $btctodollars where id = 1");	
}

return $math;
	
}

//auto withdraws any users that have positive balance and auto turned on (pass currency)
function auto_withdraw($currency){
	global $mysqli,$db_table_prefix,$errors; 
	
	$query = "Select userid, {$currency}_last_balance, {$currency}address, currency from uc_users INNER JOIN user_receive_address ON uc_users.id = user_receive_address.userid where auto$currency = 1";
		
	$stmtwithdraw = $mysqli->prepare($query);	
	$stmtwithdraw->execute();
	$stmtwithdraw->bind_result($userid, $balance, $address, $fiatcurrency);
	$count = 0;
	
	if ($currency == 'doge'){
		$min = 100;
		$reserve = 50;
	} else if ($currency == 'btc'){
		$min = .005;
		$reserve = .001;
	}
	
	while ($stmtwithdraw->fetch()){
		$withdraws[$count]['userid'] = $userid;
		$withdraws[$count]['balance'] = $balance;
		$withdraws[$count]['address'] = $address;
		$withdraws[$count]['fiatcurrency'] = $fiatcurrency;
		$count++;
	}
	$stmtwithdraw->close();

	foreach ($withdraws as $w){
		echo("\r\n===");
		if ($realbalance = get_balance($w['userid'],$currency)){
			if ($realbalance > $min){
			echo "{balance for ". $w['userid']. " is".$realbalance."}";
			withdraw($w['userid'], $currency, $realbalance-$reserve, $w['address'], $w['fiatcurrency']);
			echo "withdraw";
			}
		}
	}
	
	echo("done");
}


function currencySymbol($fiatcurrency){
		
		switch ($fiatcurrency) {
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

function global_message(){
	global $mysqli,$db_table_prefix,$errors; 

	$query = "SELECT name, value FROM uc_configuration WHERE name LIKE 'message%'";
		
	$stmt = $mysqli->prepare($query);	
	$stmt->execute();
	$stmt->bind_result($message, $value);
	
	$settings = array();
	
while ($stmt->fetch()){
	$settings[] = $value;
}

if ($settings[1] != 'disabled'){
	echo "<div class='global_message ". $settings[1] ."'>";
	echo $settings[0];
	echo "</div>";
	}
}


function add_new_address($id,$currency) {
		global $handshake;
		global $dogeWalletServer;
		global $btcWalletServer;

		
		$account = "dogepos-".$id;
		$key = $account.$handshake;
		$key = sha1($key);
		
		if ($currency == 'BTC' || $currency == 'BOTH'){
			
			
			$url = 	$dogeWalletServer . 'index.php?call=newaddress&params='.$account.'&key='.$key;
		
			//open connection
			$ch = curl_init();
			
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			//execute post
			$btcaddress = curl_exec($ch);
			//close connection
			curl_close($ch);
		}
		
		if ($currency == 'DOGE' || $currency == 'BOTH'){
			
			
			$url = 	$btcWalletServer . 'index.php?call=newaddress&params='.$account.'&key='.$key;
		
			//open connection
			$ch = curl_init();
			
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			//execute post
			$dogeaddress = curl_exec($ch);
			//close connection
			curl_close($ch);
		
		}
		
		
		global $mysqli,$db_table_prefix,$errors; 
	
		$stmtlogi = $mysqli->prepare("INSERT INTO user_receive_address (userid, doge_address, btc_address) VALUES(?, ?, ?)");
				 
	    $stmtlogi->bind_param("iss", $id, $dogeaddress, $btcaddress);
	    $stmtlogi->execute();
	    //$insertid = $stmtlog->insert_id;
	    $stmtlogi->close();			
	    
	    //return $insertid;
		
		
	
	
}



?>