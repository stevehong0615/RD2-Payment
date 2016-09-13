<?php
require_once 'connect.php';

// 開獎
function insertResult($serialNumber, $betResult, $start, $wait, $next)
{
    $connect = new Connect;

    $sql = "INSERT INTO `game_result`
        (`serial`, `bet_result`, `startdate`, `waitdate`, `nextdate`)
        VALUES (:serial, :betResult, :startdate, :waitdate, :nextdate)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':serial', $serialNumber);
    $data->bindParam(':betResult', $betResult);
    $data->bindParam(':startdate', $start);
    $data->bindParam(':waitdate', $wait);
    $data->bindParam(':nextdate', $next);
    $data->execute();

    return true;
}

// 搜尋開獎資料
function searchResult()
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_result`";

    $data = $connect->db->prepare($sql);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 搜尋account
function searchAccountData($account)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `account_data` WHERE `account` = :account";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 註冊account
function insertAccount($account, $pwd, $datetime, $balance)
{
    $connect = new Connect;

    $sql = "INSERT INTO `account_data`
        (`account`, `password`, `datetime`, `balance`)
        VALUE (:account, :password, :datetime, :balance)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->bindParam(':password', $pwd);
    $data->bindParam(':datetime', $datetime);
    $data->bindParam(':balance', $balance);
    $data->execute();

    return true;
}
