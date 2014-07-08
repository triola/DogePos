<?php

require_once("db-settings.php"); //Require DB connection


$userid = $_GET['user'];
$type = $_GET['type'];

//Retrieve settings
if ($type == "doge"){
	$stmt = $mysqli->prepare("SELECT id, doge_address FROM user_receive_address WHERE userid = $userid");	
} else if ($type == "btc") {
	$stmt = $mysqli->prepare("SELECT id, btc_address FROM user_receive_address WHERE userid = $userid");	
}
$stmt->bind_result($addressid, $address);
$stmt->execute();


while ($stmt->fetch()){
	$accountSettings = array('userid' => $userid, 'addressid' => $addressid, 'address' => $address);
}
$stmt->close();


$return = json_encode($accountSettings);
echo $return;

/*
//select the address needed
$query = "Select * from user_receive_address WHERE userid = '$userid' limit 1";
$sql = mysql_query($query) or die (mysql_error());

while ($row = mysql_fetch_array($sql)) {
	//loop through with $row as an array with the data from each row
}
*/