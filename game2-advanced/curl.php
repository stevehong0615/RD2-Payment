<?php
header("content-type: text/html; charset=utf-8");

function paymentBalance($account)
{
    $urlSearchBalance = "https://lab-stevehong0615.c9users.io/RD2-Payment/paymentAPI.php/searchBalance?account=$account";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlSearchBalance);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);

    curl_close($ch);

    return $data;
}

function paymentTransOut($account, $time, $money)
{
    $action = "OUT";

    $urlTransfer = "https://lab-stevehong0615.c9users.io/RD2-Payment/paymentAPI.php/transfer?account=$account&action=$action&time=$time&money=$money";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlTransfer);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);

    curl_close($ch);

    return true;
}

function paymentTransIn($account, $time, $money)
{
    $action = "IN";

    $urlTransfer = "https://lab-stevehong0615.c9users.io/RD2-Payment/paymentAPI.php/transfer?account=$account&action=$action&time=$time&money=$money";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlTransfer);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);

    curl_close($ch);

    return true;
}
