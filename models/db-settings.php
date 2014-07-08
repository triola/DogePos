<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

//BTC and DOGE wallet handshake key:
$handshake = 'yourWalletHandshakeKey';

//Wallet Addresses:
$dogeWalletServer = "yourdogewalletserver.com/withtrailingslash/";
$btcWalletServer = "yourbtcwalletserver.com/withtrailingslash/";


//Database Information
$db_host = "localhost"; //Host address (most likely localhost)
$db_name = "db_name"; //Name of Database
$db_user = "db_user"; //Name of database user
$db_pass = "db_password"; //Password for database user
$db_table_prefix = "dp_";

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>