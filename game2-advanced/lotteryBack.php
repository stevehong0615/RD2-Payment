<?php
set_time_limit(0);
require_once 'connect.php';

function lottery()
{
    mt_srand((double)microtime() * 1000000);
    $count = 3;
    $num = 1;
    $sleepTime = 5;
    $lotteryCount = 5;$connect = new Connect;

    while ($lotteryCount != 0) {

        $rand = Array();
        $date = date("Y-m-d");
        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
        $serialNumber = $date . " - " . $num;
        $start = date("Y-m-d h:i:s");
        $wait = date("Y-m-d h:i:s", strtotime('+60 sec'));
        $next = date("Y-m-d h:i:s", strtotime('+10 sec'));

        for ($i = 1; $i <= $count; $i++) {
            $randval = mt_rand(0, 9);
            if (in_array($randval, $rand)) {
                $i--;
            } else {
                $rand[] = $randval;
            }
        }

        $betResult = json_encode($rand);

        if ($lotteryCount > 0) {


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

            $num++;
            $lotteryCount--;
        }

        sleep($sleepTime);
    }$connect = null;
}

lottery();
