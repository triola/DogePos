<?php

require_once("db-settings.php"); //Require DB connection
require_once("cryptofunctions.php");

$amount = $_GET['amount'];
$currency = $_GET['currency'];


$value = get_btc_conversion($amount, $currency);
echo $value;
