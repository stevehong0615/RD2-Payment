<?php
require_once 'model.php';

$account = $_SESSION['account'];
$date = date("Y-m-d");
$bet1 = $_POST['bet1'];
$bet2 = $_POST['bet2'];
$bet3 = $_POST['bet3'];
$betContent1 = $bet1;
$betContent2 = $bet2;
$betContent3 = $bet3;
$betMoney = 100;

insertBet($account, $betContent1, $betContent2, $betContent3, $betMoney, $date);
$data = searchAccountData($account);

$balance = $data[0]['balance'] - $betMoney;

updateBalance($account, $balance);

$balanceData = searchAccountData($account);

echo $balanceData[0]['balance'];
