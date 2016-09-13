<?php
set_time_limit(0);
require_once 'connect.php';

$date = date("Y-m-d");

function lottery()
{
    $num = 1;
    $lotteryCount = 5;
    $date = date("Y-m-d");
    $start = time();
    $wait = $start + 5;
    $next = $start + 10;
    $betResult = "未開獎";

    $connect = new Connect;

    for ($i = 0; $i < $lotteryCount; $i++) {
        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
        $serialNumber = $date . " - " . $num;

        $sql = "INSERT INTO `game_result`
            (`serial`, `bet_result`, `startdate`, `waitdate`, `nextdate`, `today`)
            VALUES (:serial, :betResult, :startdate, :waitdate, :nextdate, :today)";

        $data = $connect->db->prepare($sql);
        $data->bindParam(':serial', $serialNumber);
        $data->bindParam(':betResult', $betResult);
        $data->bindParam(':startdate', $start);
        $data->bindParam(':waitdate', $wait);
        $data->bindParam(':nextdate', $next);
        $data->bindParam(':today', $date);
        $data->execute();

        $num++;
        $start = $next;
        $wait = $start + 5;
        $next = $start + 10;
    }

    $countRand = 3;
    $count = 0;
    $gameCount = 5;
    $num = 0;

    while ($count < $gameCount) {
        $count++;
        $num++;
        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
        $serialNumber = $date . " - " . $num;
        mt_srand((double)microtime() * 1000000);
        $rand = Array();

        for ($i = 1; $i <= $countRand; $i++) {
            $randval = mt_rand(0, 9);

            if (in_array($randval, $rand)) {
                $i--;
            } else {
                $rand[] = $randval;
            }
        }

        $betResult = json_encode($rand);

        // 開獎
        $sql = "UPDATE `game_result`
            SET `bet_result` = :betResult
            WHERE `serial` = :serial";

        $data = $connect->db->prepare($sql);
        $data->bindParam(':betResult', $betResult);
        $data->bindParam(':serial', $serialNumber);
        $data->execute();

        // 搜尋時間
        $sql = "SELECT * FROM `game_result` WHERE `serial` = :serial";

        $data = $connect->db->prepare($sql);
        $data->bindParam(':serial', $serialNumber);
        $data->execute();
        $result = $data->fetchAll();

        $sleep_time = $result[0]['nextdate'] - time();
        sleep($sleep_time);
    }

    $connect = null;
}

$connect = new Connect;

$sql = "SELECT * FROM `game_result` WHERE `today` = :date";

$data = $connect->db->prepare($sql);
$data->bindParam(':date', $date);
$data->execute();
$todayBet = $data->fetchAll();

if ($todayBet != null) {
    echo "本日開獎結束!";
} else {
    lottery();
}
