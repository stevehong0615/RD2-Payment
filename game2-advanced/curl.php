<?php
header("content-type: text/html; charset=utf-8");

$account = "william";
$action = "OUT";
$datetime = date("Y-m-d H:i:s");
$money = 1000;
$urlSearchBalance = "http://192.168.152.98/game2-advanced/paymentAPI.php/searchBalance?account=$account";
$urlTransfer = "http://192.168.152.98/game2-advanced/paymentAPI.php/transfer?account=$account&action=$action&datetime=$datetime&money=$money";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlSearchBalance);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
echo $data;
curl_close($ch);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlTransfer);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
echo $data;
curl_close($ch);
