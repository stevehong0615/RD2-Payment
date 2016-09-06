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
$result = "未開獎";
$check = "/^([0-9]+)$/";

if (!preg_match($check, $bet1) or $bet1 >= 10 or $bet1 == null ) {
    echo "第一個輸入框" . " " . $bet1 . " " . "的格式錯誤!";
    exit;
}

if (!preg_match($check, $bet2) or $bet2 >= 10 or $bet2 == null) {
    echo "第一個輸入框" . " " . $bet2 . " " . "的格式錯誤!";
    exit;
}

if (!preg_match($check, $bet3) or $bet3 >= 10 or $bet3 == null) {
    echo "第一個輸入框" . " " . $bet3 . " " . "的格式錯誤!";
    exit;
}

if ($bet1 == $bet2) {
    echo "第一個輸入框" . " " . $bet1 . " " . "與第二個輸入框" . " " . $bet2 . " " . "重複";
    exit;
}

if ($bet1 == $bet3) {
    echo "第一個輸入框" . " " . $bet1 . " " . "與第三個輸入框" . " " . $bet3 . " " . "重複！";
    exit;
}

if ($bet2 == $bet3) {
    echo "第二個輸入框" . " " . $bet2 . " " . "與第三個輸入框" . " " . $bet3 . " " . "重複！";
    exit;
}

insertBet($account, $betContent1, $betContent2, $betContent3, $betMoney, $date, $result);
$data = searchAccountData($account);

$balance = $data[0]['balance'] - $betMoney;

updateBalance($account, $balance);

$balanceData = searchAccountData($account);

echo $balanceData[0]['balance'];
