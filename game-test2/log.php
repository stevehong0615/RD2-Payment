<?php
require_once 'model.php';

$account = $_SESSION['account'];

$data = searchBetData($account);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>下注歷史</title>
</head>
<body>
<table style="border:3px #FFAC55 double;padding:5px;" rules="all" cellpadding='5';>
    <tr>
        <th>單號</th>
        <th>下注內容</th>
        <th>金額</th>
        <th>日期</th>
        <th>輸贏</th>
        <th>輸贏金額</th>
    </tr>
    <?php foreach ($data as $value) { ?>
        <tr>
            <td><?php echo $value['id']; ?></td>
            <td><?php echo $value['bet_content_1'] . $value['bet_content_2'] . $value['bet_content_3']; ?></td>
            <td><?php echo $value['bet_money']; ?></td>
            <td><?php echo $value['date']; ?></td>
            <td><?php echo $value['result']; ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>