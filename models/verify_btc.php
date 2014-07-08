<?php 
require_once("db-settings.php"); //Require DB connection
require_once("cryptofunctions.php");

$address = $_GET['address'];
$user = $_GET['user'];
$debug = $_GET['debug'];
$fiatcurrency = $_GET['fiatcurrency'];

verify_payment($address, $user, $fiatcurrency);





function verify_payment($address, $user, $fiatcurrency){
global $mysqli;


	//Retrieve address balance
	$stmt = $mysqli->prepare("Select btc_last_balance from user_receive_address where btc_address = '$address'");	
	$stmt->execute();
	$stmt->bind_result($last_balance);
	$stmt->fetch();
	$stmt->close();
	
	//echo "1";
	$validbid = check_valid($address,$last_balance);
	
	if ($validbid){
		//update adress balance
		$stmt = $mysqli->query("Update user_receive_address SET btc_last_balance = btc_last_balance+$validbid WHERE btc_address = '$address'");	

		$fiat = get_btc_conversion(1, $fiatcurrency, true);
		$fiat = $fiat * $validbid;
		log_transaction($address, $validbid, $fiat, $fiatcurrency, 'BTC', $user, "na" );

		echo $validbid;
		}
	}


function check_valid($address,$balance){
	global $lastbid;
	global $debug;
	global $handshake;
	global $btcWalletServer;

	
	//echo "::lastbid".$lastbid.":::";	
	$key = $address.$handshake;
	$key = sha1($key);
	
	$url = 	$btcWalletServer . 'index.php?call=listreceivedbyaddress&params='.$address.'&key='.$key;
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
		$payment .= $address."+++++".$result." - ".$balance." =(".$payment.")<br>";
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
