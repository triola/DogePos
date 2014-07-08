<?php

require_once("db-settings.php"); //Require DB connection
require_once("cryptofunctions.php");



$amount = $_GET['amount'];
$currency = $_GET['currency'];
$reverse = $_GET['reverse'];


$value = get_doge_conversion($amount, $currency, $reverse);
echo $value;
