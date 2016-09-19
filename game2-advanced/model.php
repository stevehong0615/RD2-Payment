<?php
require_once 'connect.php';

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

// 期號搜尋開獎資料
function searchSerialResult($serial)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_result` WHERE `serial` = :serial";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':serial', $serial);
    $data->execute();
    $result = $data->fetch();

    return $result;
}

// 今日開獎資料
function searchTodayResult($date)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_result` WHERE `today` = :date";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':date', $date);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

// 搜尋期號
function searchSerial($time)
{
    $connect = new Connect;

    $sql = "SELECT `serial` FROM `game_result` WHERE `startdate` <= :time AND `waitdate` >= :time";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':time', $time);
    $data->bindParam(':time', $time);
    $data->execute();
    $result = $data->fetch();

    return $result;
}

function getNotYetOpen($date){
    $sql = "SELECT * FROM `game_result` WHERE `today` = :date AND `bet_result` = '未開獎' ORDER BY `id` LIMIT 1";
    $connect = new Connect;

    $data = $connect->db->prepare($sql);
    $data->bindParam(':date', $date);
    $data->execute();
    $result = $data->fetch();

    return $result;
}

function checkIsRunning($date){
    $sql = "SELECT * FROM `game_result` WHERE `today` = :date";
    $connect = new Connect;

    $data = $connect->db->prepare($sql);
    $data->bindParam(':date', $date);
    $data->execute();
    $result = $data->fetchAll();

    return sizeOf($result) <= 0 ? false: true ;
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

// 下注
function insertBet($account, $serial, $betRand, $betMoney, $time, $result)
{
    $connect = new Connect;

    $sql = "INSERT INTO `game_money`
        (`account`, `serial`, `bet_content`, `bet_money`, `time`, `result`)
        VALUES (:account, :serial, :betRand, :betMoney, :time, :result)";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->bindParam(':serial', $serial);
    $data->bindParam(':betRand', $betRand);
    $data->bindParam(':betMoney', $betMoney);
    $data->bindParam(':time', $time);
    $data->bindParam(':result', $result);
    $data->execute();

    return true;
}

// 下注資料
function searchAllBetData()
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_money`";

    $data = $connect->db->prepare($sql);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}
