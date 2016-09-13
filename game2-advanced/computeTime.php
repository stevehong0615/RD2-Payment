<?php
require_once 'model.php';

$date = date("Y-m-d");
$result = searchTodayResult($date);

if ($result != null) {
    for ($i = 0; $i < count($result); $i++) {
        $count = count($result) - 1;
        if (time() < $result[$i]['nextdate'] && time() >= $result[$i]['startdate']) {
            $rTime = $result[$i]['nextdate'] - time();
            echo $rTime;
        }

        if (time() > $result[$count]['startdate']) {
            echo "本日開獎結束！";
            exit;
        }
    }
} else {
    echo "本日尚未開獎！";
}