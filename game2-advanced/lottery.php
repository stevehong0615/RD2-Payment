<?php
set_time_limit(0);

require_once 'model.php';

mt_srand((double)microtime() * 1000000);
$rand = Array();
$count = 3;
$date = date("Y-m-d");
$num = 1;
$num = str_pad($num, 3, '0', STR_PAD_LEFT);
$serialNumber = $date . " - " . $num;
$start = date("Y-m-d h:i:s");
$wait = date("Y-m-d h:i:s", strtotime('+60 sec'));
$next = date("Y-m-d h:i:s", strtotime('+20 sec'));
$resultSite = "二字定位（贏）";
$resultMix = "二字組合（贏）";
$resultLose = "未中獎（輸）";

for ($i = 1; $i <= $count; $i++) {
    $randval = mt_rand(0, 9);
    if (in_array($randval, $rand)) {
        $i--;
    } else {
        $rand[] = $randval;
    }
}

$betResult1 = $rand[0];
$betResult2 = $rand[1];
$betResult3 = $rand[2];
$betResult = array($betResult1, $betResult2, $betResult3);

$betResult =  json_encode($betResult);

insertResult($serialNumber, $betResult, $start, $wait, $next);


//
//$allBet = searchAllBet($date, $start);
//
//updateLose($start, $date, $resultLose);
//
//for ($i=0; $i < count($allBet); $i++) {
//    // 二字定位中中x
//    if ($allBet[$i]['bet_content_1'] == $rand[0] && $allBet[$i]['bet_content_2'] == $rand[1] && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
//        updateSite($allBet[$i]['id'], $resultSite);
//        $balance = searchAccountData($allBet[$i]['account']);
//        $money = searchBetIdData($allBet[$i]['id']);
//        $balance = $balance[0]['balance'] + $money[0]['bet_money'];
//        updateBalance($allBet[$i]['account'], $balance);
//    }
//
//    // 二字定位中x中
//    if ($allBet[$i]['bet_content_1'] == $rand[0] && $allBet[$i]['bet_content_3'] == $rand[2] && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
//        updateSite($allBet[$i]['id'], $resultSite);
//        $balance = searchAccountData($allBet[$i]['account']);
//        $money = searchBetIdData($allBet[$i]['id']);
//        $balance = $balance[0]['balance'] + $money[0]['bet_money'];
//        updateBalance($allBet[$i]['account'], $balance);
//    }
//
//    // 二字定位x中中
//    if ($allBet[$i]['bet_content_2'] == $rand[1] && $allBet[$i]['bet_content_3'] == $rand[2] && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
//        updateSite($allBet[$i]['id'], $resultSite);
//        $balance = searchAccountData($allBet[$i]['account']);
//        $money = searchBetIdData($allBet[$i]['id']);
//        $balance = $balance[0]['balance'] + $money[0]['bet_money'];
//        updateBalance($allBet[$i]['account'], $balance);
//    }
//
//    // 二字組合中中x
//    if (in_array($allBet[$i]['bet_content_1'], $betResult) && in_array($allBet[$i]['bet_content_2'], $betResult) && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
//        $result = searchBetIdData($allBet[$i]['id']);
//        if ($result[0]['result'] != "二字定位（贏）") {
//            updateMix($allBet[$i]['id'], $resultMix);
//            $balance = searchAccountData($allBet[$i]['account']);
//            $money = searchBetIdData($allBet[$i]['id']);
//            $balance = $balance[0]['balance'] + $money[0]['bet_money'];
//            updateBalance($allBet[$i]['account'], $balance);
//        }
//    }
//
//    // 二字組合中X中
//    if (in_array($allBet[$i]['bet_content_1'], $betResult) && in_array($allBet[$i]['bet_content_3'], $betResult) && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
//        $result = searchBetIdData($allBet[$i]['id']);
//        if ($result[0]['result'] != "二字定位（贏）") {
//            updateMix($allBet[$i]['id'], $resultMix);
//            $balance = searchAccountData($allBet[$i]['account']);
//            $money = searchBetIdData($allBet[$i]['id']);
//            $balance = $balance[0]['balance'] + $money[0]['bet_money'];
//            updateBalance($allBet[$i]['account'], $balance);
//        }
//    }
//
//    // 二字組合X中中
//    if (in_array($allBet[$i]['bet_content_2'], $betResult) && in_array($allBet[$i]['bet_content_3'], $betResult) && $allBet[$i]['date'] >= $start && $allBet[$i]['date'] <= $date) {
//        $result = searchBetIdData($allBet[$i]['id']);
//        if ($result[0]['result'] != "二字定位（贏）") {
//            updateMix($allBet[$i]['id'], $resultMix);
//            $balance = searchAccountData($allBet[$i]['account']);
//            $money = searchBetIdData($allBet[$i]['id']);
//            $balance = $balance[0]['balance'] + $money[0]['bet_money'];
//            updateBalance($allBet[$i]['account'], $balance);
//        }
//    }
//}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>開獎號碼</title>
</head>
<body>
<a id = "aaa"></a>
<form method = "post" action = "">
    <input type = "submit" name = "btn" value = "開獎!">
</form>
<table style="border:3px #FFAC55 double;padding:5px;" rules="all" cellpadding='5';>
    <tr>
        <th>期數</th>
        <th colspan = "3">開獎號碼</th>
        <th>開獎時間</th>
        <th>下注開始時間</th>
        <th>下次開獎時間</th>
    </tr>
    <tr>
        <td><?php echo $serialNumber; ?></td>
        <td><?php echo $rand[0]; ?></td>
        <td><?php echo $rand[1]; ?></td>
        <td><?php echo $rand[2]; ?></td>
        <td><?php echo $start; ?></td>
        <td><?php echo $wait; ?></td>
        <td><?php echo $next; ?></td>
    </tr>
</table>
</body>
</html>
