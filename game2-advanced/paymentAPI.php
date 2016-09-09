<?php
header("content-type: text/html; charset=utf-8");

require_once 'connect.php';

$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$urlAP = explode('?', $url[3]);
$en = "/^([0-8A-Za-z]+)$/";
$number = "/^([0-9]+)$/";
$datetime = date("Y-m-d H:i:s");
$account_info = array();

// API名稱
$api = $urlAP[0];
// Parameter名稱
$urlP = explode('=', $urlAP[1]);

// 餘額查詢
if ($api == "searchBalance") {
    $account = $urlP[1];
    if ($urlP[0] != "account") {
        $account_info = array("message" => "input error!");

        exit(json_encode($account_info));
    }

    if (!preg_match($en, $account)) {
        $account_info = array("message" => "account error!");

        exit(json_encode($account_info));
    }

    $searchAccount = searchAccount($account);
    $balance = $searchAccount[0]['balance'];

    if ($searchAccount[0]['account'] == $account) {
        $account_info = array("account" => "$account", "balance" => "$balance");

        exit(json_encode($account_info));
    }

    if ($searchAccount[0]['account'] != $account) {
        $account_info = array("message" => "not found account");

        exit(json_encode($account_info));
    }
}

// 出款、入款
if ($api == "transfer") {
    $urlPone = explode('&', $urlP[1]);
    $urlPtwo = explode('&', $urlP[2]);
    $urlPthree = explode('&', $urlP[3]);
    $account = $urlPone[0];
    $action = $urlPtwo[0];
    $datetime = $urlPthree[0];
    $money = $urlP[4];

    if ($urlP[0] != "account" or $urlPone[1] != "action" or $urlPtwo[1] != "datetime" or $urlPthree[1] != "money") {
        $account_info = array("message" => "input error!");

        exit(json_encode($account_info));
    }

    if (!preg_match($en, $account)) {
        $account_info = array("message" => "account error!");

        exit(json_encode($account_info));
    }

    if (!preg_match($number, $money)) {
        $account_info = array("message" => "money error!");

        exit(json_encode($account_info));
    }

    $searchAccount = searchAccount($account);
    if ($action == "OUT") {
        if ($searchAccount[0]['balance'] < $money) {
            $account_info = array("message" => "balance isn't enough!");

            exit(json_encode($account_info));
        }

        if ($searchAccount[0]['balance'] >= $money) {
            $balance = $searchAccount[0]['balance'] - $money;
        }
    }

    if ($action == "IN") {
        $balance = $searchAccount[0]['balance'] + $money;
    }

    if ($searchAccount[0]['account'] != $account) {
        $account_info = array("message" => "not found account");

        exit(json_encode($account_info));
    }

    if ($searchAccount[0]['account'] == $account) {
        insertData($account, $action, $datetime, $money, $balance);
        updateBalance($account, $balance);

        $account_info = array("message" => "trans success!");

        exit(json_encode($account_info));
    }
}

function searchAccount($account)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `account_data` WHERE `account` = :account";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

function insertData($account, $action , $datetime, $money, $balance)
{
    $connect = new Connect;

    $sql = "INSERT INTO `payment_data`
        (`account`, `action`, `datetime`, `money`, `balance`)
        VALUES (:account, :action, :datetime, :money, :balance)";

    $addData = $connect->db->prepare($sql);
    $addData->bindParam(':account', $account);
    $addData->bindParam(':action', $action);
    $addData->bindParam(':datetime', $datetime);
    $addData->bindParam(':money', $money);
    $addData->bindParam(':balance', $balance);
    $addData->execute();

    return true;
}

function updateBalance($account, $balance)
{
    $connect = new Connect;

    $sql = "UPDATE `account_data`
        SET `balance` = :balance
        WHERE `account` = :account";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->bindParam(':balance', $balance);
    $data->execute();

    return true;
}
