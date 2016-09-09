<?php
require_once 'connect.php';

function searchLottery()
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_result` ORDER BY `id` DESC";

    $data = $connect->db->prepare($sql);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

function searchCheck()
{
    $id = 1;

    $connect = new Connect;

    $sql = "SELECT * FROM `check` WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':id', $id);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

function updateCheck($check)
{
    $id = 1;

    $connect = new Connect;

    $sql = "UPDATE `check`
        SET `check` = :check
        WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':id', $id);
    $data->bindParam(':check', $check);
    $data->execute();

    return true;
}

$result = searchLottery();
$check = searchCheck();
$check = $check[0]['check'];

if ($check < 40) {
    $endtime = $result[0]['nextdate'];
    $endtime = strtotime($endtime);
    $now = date("Y-m-d h:i:s");
    $now = strtotime($now);
    $check++;
    updateCheck($check);
    echo $endtime - $now + 1;
} else {
    echo "本日結束";
}

//if ($check[0]['check'] == 1) {
//    $endtime = $result[0]['nextdate'];
//    $endtime = date($endtime, strtotime('+9 min'));
//    $endtime = strtotime($endtime);
//    $now = time();
//    $upcheck = 1;
//    updateCheck($upcheck);
//    echo $endtime - $now;
//}

