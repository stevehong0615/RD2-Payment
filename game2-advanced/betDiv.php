<?php
require_once 'model.php';
require_once 'curl.php';

if (!isset($_SESSION)) {
    session_start();
}

$account = $_SESSION['account'];
$time = time();
$bet1 = $_POST['bet1'];
$bet2 = $_POST['bet2'];
$bet3 = $_POST['bet3'];
$betMoney = $_POST['money'];
$result = "未開獎";
$check = "/^([0-9]+)$/";
$rand = Array();

$data = paymentBalance($account);
$data = json_decode($data, true);

if(!preg_match($check, $betMoney) && $betMoney <= 0) {
    echo "金額輸入錯誤";
    exit;
}

if ($data['balance'] < $betMoney) {
    echo "餘額不足";
    exit;
}

if (!preg_match($check, $bet1) or $bet1 >= 10 or $bet1 == null) {
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

$rand = [$bet1, $bet2, $bet3];
$betRand = json_encode($rand);
$money = $_POST['money'];

insertBet($account, $betRand, $betMoney, $time, $result);

paymentTransOut($account, $time, $money);

$result = paymentBalance($account);
$result = json_decode($result, true);
echo $result['balance'];
