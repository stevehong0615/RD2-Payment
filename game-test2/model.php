<?php
require_once 'connect.php';

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
function insertBet($account, $betContent1, $betContent2, $betContent3, $betMoney, $date, $result)
{
    $connect = new Connect;

    $sql = "INSERT INTO `game_money`
        (`account`, `bet_content_1`, `bet_content_2`, `bet_content_3`, `bet_money`, `date`, `result`)
        VALUES (:account, :betContent1, :betContent2, :betContent3, :betMoney, :date, :result)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->bindParam(':betContent1', $betContent1);
    $data->bindParam(':betContent2', $betContent2);
    $data->bindParam(':betContent3', $betContent3);
    $data->bindParam(':betMoney', $betMoney);
    $data->bindParam(':date', $date);
    $data->bindParam(':result', $result);
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
function insertResult($betResult1, $betResult2, $betResult3, $start, $date)
{
    $connect = new Connect;

    $sql = "INSERT INTO `game_result`
        (`bet_result_1`, `bet_result_2`, `bet_result_3`, `startdate`, `date`)
        VALUES (:betResult1, :betResult2, :betResult3, :start, :date)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':betResult1', $betResult1);
    $data->bindParam(':betResult2', $betResult2);
    $data->bindParam(':betResult3', $betResult3);
    $data->bindParam(':start', $start);
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

// 搜尋本期開獎下注歷史
function searchAllBet($date, $start)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_money` WHERE `date` <= :date AND `date` >= :start";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':date', $date);
    $data->bindParam(':start', $start);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 二字定位輸贏
function updateSite($id, $resultSite)
{
    $connect = new Connect;

    $sql = "UPDATE `game_money`
        SET `result` = :result
        WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':id', $id);
    $data->bindParam(':result', $resultSite);
    $data->execute();

    return true;
}

// log by id
function searchBetIdData($id)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_money` WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':id', $id);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 二字組合輸贏
function updateMix($id, $resultMix)
{
    $connect = new Connect;

    $sql = "UPDATE `game_money`
        SET `result` = :result
        WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':id', $id);
    $data->bindParam(':result', $resultMix);
    $data->execute();

    return true;
}

// 未中獎
function updateLose($start, $date, $resultLose)
{
    $connect = new Connect;

    $sql = "UPDATE `game_money`
        SET `result` = :result
        WHERE `date` >= :start AND `date` <= :date";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':start', $start);
    $data->bindParam(':date', $date);
    $data->bindParam(':result', $resultLose);
    $data->execute();

    return true;
}
