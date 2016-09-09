<?php
require_once 'model.php';

$result = searchResult();
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
        <th>日期</th>
        <th>開獎號碼</th>
    </tr>
    <?php foreach ($result as $value) { ?>
    <tr>
        <td><?php echo $value['date']; ?></td>
        <td><?php echo $value['bet_result_1'] . $value['bet_result_2'] . $value['bet_result_3']; ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
