<?php
require_once 'model.php';

$date = date("Y-m-d");
$result = getNotYetOpen($date);
$isRunning = checkIsRunning($date);

$data = [
    'msg' => '',
    'sec' => '-1'
];

if (!$isRunning) {
    $data['msg'] = "本日尚未開獎！";
} else {
    if($result['nextdate'] - time() < 0){
        $data['msg'] = "本日開獎結束！";
    }else{
        $counter = $result['nextdate'] - time();
        $data['msg'] = "下期開獎時間剩餘 {sec} 秒";
        $data['sec'] = $counter;
    }
}

echo json_encode($data);
