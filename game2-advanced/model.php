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

// 搜尋帳號資料
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


