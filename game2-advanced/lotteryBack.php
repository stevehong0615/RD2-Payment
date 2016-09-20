<?php
set_time_limit(0);
require_once 'connect.php';
require_once 'curl.php';

$date = date("Y-m-d");

function lottery()
{
    $num = 1;
    $lotteryCount = 3;
    $date = date("Y-m-d");
    $start = time();
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

//        for ($i = 1; $i <= $countRand; $i++) {
//            $randval = mt_rand(0, 9);
//
//            if (in_array($randval, $rand)) {
//                $i--;
//            } else {
//                $rand[] = $randval;
//            }
//        }
//
//        $betResult = json_encode($rand);
        $rand = [0, 1, 2];
        $betResult = json_encode($rand);

        // 開獎
        $sql = "UPDATE `game_result`
            SET `bet_result` = :betResult
            WHERE `serial` = :serial";

        $data = $connect->db->prepare($sql);
        $data->bindParam(':betResult', $betResult);
        $data->bindParam(':serial', $serialNumber);
        $data->execute();

        $allBet = searchBetResult($serialNumber);

        // 兌獎
        for ($i=0; $i < count($allBet); $i++) {
            $resultBet = $allBet[$i]['bet_content'];
            $resultBetRand = json_decode($resultBet, true);

            // 二字定位中中x
            if ($resultBetRand[0] == $rand[0] && $resultBetRand[1] == $rand[1]) {
                $allBet = searchBetResult($serialNumber);
                if ($allBet[$i]['result'] == "未開獎") {
                    $id = $allBet[$i]['id'];
                    $money = $allBet[$i]['bet_money'];
                    $account = $allBet[$i]['account'];
                    $paymentTime = time();
                    $resultSite = "二字定位（贏）";
                    updateSite($resultSite, $id);
                    paymentTransIn($account, $paymentTime, $money);
                }
            }

            // 二字定位中x中
            if ($resultBetRand[0] == $rand[0] && $resultBetRand[2] == $rand[2]) {
                $allBet = searchBetResult($serialNumber);
                if ($allBet[$i]['result'] == "未開獎") {
                    $id = $allBet[$i]['id'];
                    $money = $allBet[$i]['bet_money'];
                    $account = $allBet[$i]['account'];
                    $paymentTime = time();
                    $resultSite = "二字定位（贏）";
                    updateSite($resultSite, $id);
                    paymentTransIn($account, $paymentTime, $money);
                }
            }

            // 二字定位x中中
            if ($resultBetRand[1] == $rand[1] && $resultBetRand[2] == $rand[2]) {
                $allBet = searchBetResult($serialNumber);
                if ($allBet[$i]['result'] == "未開獎") {
                    $id = $allBet[$i]['id'];
                    $money = $allBet[$i]['bet_money'];
                    $account = $allBet[$i]['account'];
                    $paymentTime = time();
                    $resultSite = "二字定位（贏）";
                    updateSite($resultSite, $id);
                    paymentTransIn($account, $paymentTime, $money);
                }
            }

            $allBet = searchBetResult($serialNumber);

            // 二字組合中中x
            if (in_array($resultBetRand[0], $rand) && in_array($resultBetRand[1], $rand)) {
                if ($allBet[$i]['result'] != "二字定位（贏）") {
                    $id = $allBet[$i]['id'];
                    $money = $allBet[$i]['bet_money'];
                    $account = $allBet[$i]['account'];
                    $paymentTime = time();
                    $resultMix = "二字組合（贏）";
                    updateMix($resultMix, $id);
                    paymentTransIn($account, $paymentTime, $money);
                }
            }

            // 二字組合中X中
            if (in_array($resultBetRand[0], $rand) && in_array($resultBetRand[2], $rand)) {
                if ($allBet[$i]['result'] != "二字定位（贏）") {
                    $id = $allBet[$i]['id'];
                    $money = $allBet[$i]['bet_money'];
                    $account = $allBet[$i]['account'];
                    $paymentTime = time();
                    $resultMix = "二字組合（贏）";
                    updateMix($resultMix, $id);
                    paymentTransIn($account, $paymentTime, $money);
                }
            }

            // 二字組合X中中
            if (in_array($resultBetRand[1], $rand) && in_array($resultBetRand[2], $rand)) {
                if ($allBet[$i]['result'] != "二字定位（贏）") {
                    echo "6";
                    $id = $allBet[$i]['id'];
                    $money = $allBet[$i]['bet_money'];
                    $account = $allBet[$i]['account'];
                    $paymentTime = time();
                    $resultMix = "二字組合（贏）";
                    updateMix($resultMix, $id);
                    paymentTransIn($account, $paymentTime, $money);
                }
            }

            $allBet = searchBetResult($serialNumber);

            if ($allBet[$i]['result'] == "未開獎") {
                $id = $allBet[$i]['id'];
                $resultNo = "未中獎";

                updateNo($resultNo, $id);
            }
        }

        // 搜尋時間
        $sql = "SELECT * FROM `game_result` WHERE `serial` = :serial";

        $data = $connect->db->prepare($sql);
        $data->bindParam(':serial', $serialNumber);
        $data->execute();
        $result = $data->fetchAll();

        $sleep_time = $result[0]['nextdate'] - time() + 30;
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

// 二字定位中獎
function updateSite($resultSite, $id)
{
    $connect = new Connect;

    $sql = "UPDATE `game_money`
            SET `result` = :result
            WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':result', $resultSite);
    $data->bindParam(':id', $id);
    $data->execute();
}

// 二字組合中獎
function updateMix($resultMix, $id)
{
    $connect = new Connect;

    $sql = "UPDATE `game_money`
            SET `result` = :result
            WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':result', $resultMix);
    $data->bindParam(':id', $id);
    $data->execute();
}

// 未中獎
function updateNo($resultNo, $id)
{
    $connect = new Connect;

    $sql = "UPDATE `game_money`
            SET `result` = :result
            WHERE `id` = :id";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':result', $resultNo);
    $data->bindParam(':id', $id);
    $data->execute();
}

// 核對下注資料
function searchBetResult($serialNumber)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `game_money` WHERE `serial` = :serial";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':serial', $serialNumber);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}
