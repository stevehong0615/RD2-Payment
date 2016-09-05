<?php
require_once 'model.php';

mt_srand((double) microtime() * 1000000);
$rand = Array();
$count = 3;
$date = date("Y-m-d");

for ($i = 1; $i <= $count; $i++) {
    $randval = mt_rand(0, 9);
    if (in_array($randval, $rand)) {
        $i--;
    } else {
        $rand[] = $randval;
    }
}

$betResult = $rand[0] . $rand[1] . $rand[2];

insertResult($betResult, $date);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>開獎號碼</title>
</head>
<body>
<table style="border:3px #FFAC55 double;padding:5px;" rules="all" cellpadding='5';>
    <tr>
        <th colspan = "3">本期開獎號碼</th>
    </tr>
    <tr>
        <td><?php echo $rand[0]; ?></td>
        <td><?php echo $rand[1]; ?></td>
        <td><?php echo $rand[2]; ?></td>
    </tr>
</table>
</body>
</html>
