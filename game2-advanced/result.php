<?php
require_once 'model.php';

$date = date("Y-m-d");
$result = searchTodayResult($date);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>開獎號碼</title>
</head>
<body>
<div class = "table-responsive">
    <table class = "table">
        <tr>
            <th>開獎期號</th>
            <th>開獎號碼</th>
        </tr>
        <?php
        foreach ($result as $value) {
            $betResult = json_decode($value['bet_result']);
        ?>
        <tr class="danger">
            <td><?php echo $value['serial']; ?></td>
            <td><?php echo $betResult[0] . $betResult[1] . $betResult[2]; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
