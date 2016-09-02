<?php
require_once 'model.php';
ini_set('display_errors', true);

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
        <td><?php echo $value['bet_result']; ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
