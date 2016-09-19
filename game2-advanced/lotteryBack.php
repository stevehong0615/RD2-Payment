<?php
set_time_limit(0);
require_once 'connect.php';

$date = date("Y-m-d");

function lottery()
{
    $num = 1;
    $lotteryCount = 3;
    $date = date("Y-m-d");
    $start = time()+30;
    $wait = $start + 20;
    $next = $start + 30;
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
        $wait = $start + 20;
        $next = $start + 30;
    }

    sleep(30);

    $countRand = 3;
    $count = 0;
    $gameCount = 3;
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

        // 兌獎
        /*for ($i=0; $i < count($allBet); $i++) {
            // 二字定位中中x
            if ($allBet[$i]['bet_content_1'] == $rand[0] && $allBet[$i]['bet_content_2'] == $rand[1] && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
                updateSite($allBet[$i]['id'], $resultSite);
                $balance = searchAccountData($allBet[$i]['account']);
                $money = searchBetIdData($allBet[$i]['id']);
                $balance = $balance[0]['balance'] + $money[0]['bet_money'];
                updateBalance($allBet[$i]['account'], $balance);
            }

            // 二字定位中x中
            if ($allBet[$i]['bet_content_1'] == $rand[0] && $allBet[$i]['bet_content_3'] == $rand[2] && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
                updateSite($allBet[$i]['id'], $resultSite);
                $balance = searchAccountData($allBet[$i]['account']);
                $money = searchBetIdData($allBet[$i]['id']);
                $balance = $balance[0]['balance'] + $money[0]['bet_money'];
                updateBalance($allBet[$i]['account'], $balance);
            }

            // 二字定位x中中
            if ($allBet[$i]['bet_content_2'] == $rand[1] && $allBet[$i]['bet_content_3'] == $rand[2] && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
                updateSite($allBet[$i]['id'], $resultSite);
                $balance = searchAccountData($allBet[$i]['account']);
                $money = searchBetIdData($allBet[$i]['id']);
                $balance = $balance[0]['balance'] + $money[0]['bet_money'];
                updateBalance($allBet[$i]['account'], $balance);
            }

            // 二字組合中中x
            if (in_array($allBet[$i]['bet_content_1'], $betResult) && in_array($allBet[$i]['bet_content_2'], $betResult) && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
                $result = searchBetIdData($allBet[$i]['id']);
                if ($result[0]['result'] != "二字定位（贏）") {
                    updateMix($allBet[$i]['id'], $resultMix);
                    $balance = searchAccountData($allBet[$i]['account']);
                    $money = searchBetIdData($allBet[$i]['id']);
                    $balance = $balance[0]['balance'] + $money[0]['bet_money'];
                    updateBalance($allBet[$i]['account'], $balance);
                }
            }

            // 二字組合中X中
            if (in_array($allBet[$i]['bet_content_1'], $betResult) && in_array($allBet[$i]['bet_content_3'], $betResult) && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
                $result = searchBetIdData($allBet[$i]['id']);
                if ($result[0]['result'] != "二字定位（贏）") {
                    updateMix($allBet[$i]['id'], $resultMix);
                    $balance = searchAccountData($allBet[$i]['account']);
                    $money = searchBetIdData($allBet[$i]['id']);
                    $balance = $balance[0]['balance'] + $money[0]['bet_money'];
                    updateBalance($allBet[$i]['account'], $balance);
                }
            }

            // 二字組合X中中
            if (in_array($allBet[$i]['bet_content_2'], $betResult) && in_array($allBet[$i]['bet_content_3'], $betResult) && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
                $result = searchBetIdData($allBet[$i]['id']);
                if ($result[0]['result'] != "二字定位（贏）") {
                    updateMix($allBet[$i]['id'], $resultMix);
                    $balance = searchAccountData($allBet[$i]['account']);
                    $money = searchBetIdData($allBet[$i]['id']);
                    $balance = $balance[0]['balance'] + $money[0]['bet_money'];
                    updateBalance($allBet[$i]['account'], $balance);
                }
            }
        }*/

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
