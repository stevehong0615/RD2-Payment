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

// 新增帳號
if ($api == "addAccount") {
    $urlPS = explode('&', $urlP[1]);
    $account = $urlPS[0];
    $password = $urlP[2];
    $pwd = md5($password);

    if ($urlP[0] != "account" or $urlPS[1] != "password") {
        $account_info = array("message" => "input error!");

        exit(json_encode($account_info));
    }

    if ($password == null) {
        $account_info = array("message" => "password error!");

        exit(json_encode($account_info));
    }

    if (!preg_match($en, $account)) {
        $account_info = array("message" => "account error!");

        exit(json_encode($account_info));
    }

    if (!preg_match($en, $password)) {
        $account_info = array("message" => "password error!");

        exit(json_encode($account_info));
    }

    $searchAccount = searchAccount($account);

    if ($searchAccount[0]['account'] == $account) {
        $account_info = array("message" => "account repeat!");

        exit(json_encode($account_info));
    }

    if ($searchAccount[0]['account'] != $account) {
        addAccount($account, $pwd, $datetime);

        $account_info = array("message" => "add account success!");

        exit(json_encode($account_info));
    }
}

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
    $balance = "$" . $searchAccount[0]['balance'];
    if ($searchAccount[0]['account'] == $account) {
        $account_info = array("account" => "$account", "balance" => "$balance");

        exit(json_encode($account_info));
    }

    if ($searchAccount[0]['account'] != $account) {
        $account_info = array("message" => "not found account");

        exit(json_encode($account_info));
    }
}

if ($api == "GGG") {
    $aa = $_GET['aa'];
    echo $aa;
}

function addAccount($account, $pwd, $datetime)
{
    $balance = 100000;

    $connect = new Connect;

    $sql = "INSERT INTO `account_data`
        (`account`, `password`, `datetime`, `balance`)
        VALUES (:account, :password, :datetime, :balance)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->bindParam(':password', $pwd);
    $data->bindParam(':datetime', $datetime);
    $data->bindParam(':balance', $balance);
    $data->execute();

    return true;
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
