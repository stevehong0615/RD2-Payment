<?php
require_once 'connect.php';
ini_set('display_errors', true);
if (!isset($_SESSION)) {
    session_start();
}

// 新增帳號
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

// 搜尋開獎號碼
function searchResult()
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_result` ORDER BY `id` DESC";

    $data = $connect->db->prepare($sql);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 下注
function insertBet($account, $betContent, $betMoney, $date)
{
    $connect = new Connect;

    $sql = "INSERT INTO `game_money`
        (`account`, `bet_content`, `bet_money`, `date`)
        VALUES (:account, :betContent, :betMoney, :date)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->bindParam(':betContent', $betContent);
    $data->bindParam(':betMoney', $betMoney);
    $data->bindParam(':date', $date);
    $data->execute();

    return true;
}

// 下注歷史
function searchBetData($account)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_money` WHERE `account` = :account";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 修改餘額
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

// 開獎
function insertResult($betResult, $date)
{
    $connect = new Connect;

    $sql = "INSERT INTO `game_result`
        (`bet_result`, `date`)
        VALUES (:betResult, :date)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':betResult', $betResult);
    $data->bindParam(':date', $date);
    $data->execute();

    return true;
}

// 搜尋餘額
function searchBalance($account)
{
    $connect = new Connect;

    $sql = "SELECT `balance` FROM `account_data` WHERE `account` = :account";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();
    $result = $result[0]['balance'];

    return $result;
}
