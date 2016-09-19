<?php
header("content-type: text/html; charset=utf-8");
session_start();

$account = $_SESSION['account'];
$urlSearchBalance = "https://lab-stevehong0615.c9users.io/RD2-Payment/paymentAPI.php/searchBalance?account=$account";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlSearchBalance);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

$data = json_decode($data, true);
echo $data['balance'];
