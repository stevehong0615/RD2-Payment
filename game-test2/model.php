<?php
require_once 'connect.php';
ini_set('display_errors', true);
session_start();

function insertAccount($account, $pwd, $datetime, $balance)
{
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

function searchBalance($account)
{
    $connect = new Connect;

    $sql = "SELECT `balance` FROM `payment_data` WHERE `account` = :account ORDER BY `id` DESC FOR UPDATE";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();
    $result = $result[0]['balance'];

    return $result;
}