<?php
require_once 'model.php';

$date = date("Y-m-d");
$result = getNotYetOpen($date);
$isRunning = checkIsRunning($date);

if (!$isRunning) {
    echo "本日尚未開獎！";
    exit;
} else {
    if($result['nextdate'] - time() - 10 < 0){
        echo "本日開獎結束！";
    }else{
        echo $result['nextdate'] - time() - 10;
    }

}
