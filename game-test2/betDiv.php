<?php
require_once 'model.php';

$account = $_SESSION['account'];
$date = date("Y-m-d");
$bet1 = $_POST['bet1'];
$bet2 = $_POST['bet2'];
$bet3 = $_POST['bet3'];
$betContent = $bet1 . $bet2 . $bet3;
$betMoney = 100;

insertBet($account, $betContent, $betMoney, $date);
$data = searchAccountData($account);

$balance = $data[0]['balance'] - $betMoney;

updateBalance($account, $balance);
