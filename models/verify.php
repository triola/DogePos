<?php 
require_once("db-settings.php"); //Require DB connection
require_once("cryptofunctions.php");
require_once("funcs.php");


$address = $_GET['address'];
$user = $_GET['user'];
$debug = $_GET['debug'];
$fiatcurrency = $_GET['fiatcurrency'];
$getinsert = $_GET['getinsert'];
$customer = $_GET['customer'];
//$customer = json_decode($customer);

//print_r($customer);
//echo "test";

verify_payment($address, $user, $fiatcurrency);





function verify_payment($address, $user, $fiatcurrency){
global $mysqli;
global $getinsert;

	//Retrieve address balance
	$stmt = $mysqli->prepare("Select doge_last_balance from user_receive_address where doge_address = '$address'");	
	$stmt->execute();
	$stmt->bind_result($last_balance);
	$stmt->fetch();
	$stmt->close();
	
	//echo "1";
	$validbid = check_valid($address,$last_balance);
	
	if ($validbid){
		//update adress balance
		//echo $validbid."--".$address;
		$stmt = $mysqli->query("Update user_receive_address SET doge_last_balance = doge_last_balance+$validbid WHERE doge_address = '$address'");	
		//echo "(" . $address . "==" . $validbid . "==" . $user . ")";
		
		$fiat = get_doge_conversion(1, $fiatcurrency, true);
		$fiat = $fiat * $validbid;
		$insertid = log_transaction($address, $validbid, $fiat, $fiatcurrency, 'DOGE', $user, "na" );

		echo $validbid;
		if ($getinsert == true){
			echo ":::".$insertid;
		}
	}
}


function check_valid($address,$balance){
	global $lastbid;
	global $debug;
	global $handshake;
	global $dogeWalletServer;
	
	//echo "::lastbid".$lastbid.":::";	
	$key = $address.$handshake;
	$key = sha1($key);
	
	$url = 	$dogeWalletServer . 'index.php?call=listreceivedbyaddress&params='.$address.'&key='.$key;
	//open connection
	$ch = curl_init();
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	//execute post
	$result = curl_exec($ch);
	//close connection
	curl_close($ch);
	
	
	$payment = $result - $balance;
	
	if ($debug){ 
		echo $address."+++++".$result." - ".$balance." =(".$payment.")<br>";
	}
	
	return $payment;
	
	/*echo "the bid is".$bid."======";
		
if ($bid > $lastbid) {
			return "1:::".$bid;
		} else {
			return "0:::".$bid;
		}
*/
		
}
