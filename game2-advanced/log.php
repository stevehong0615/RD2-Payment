<?php
require_once 'model.php';

if (!isset($_SESSION)) {
    session_start();
}
$account = $_SESSION['account'];

$data = searchBetData($account);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>下注歷史</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class = "container">
    <div class = "table-responsive">
        <table class = "table">
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
                    <td>
                        <?php
                            $result = $value['bet_content'];
                            $bet = json_decode($result, true);
                            echo $bet[0] . $bet[1] . $bet[2];
                        ?>
                    </td>
                    <td><?php echo $value['bet_money']; ?></td>
                    <td>
                        <?php
                            $date = date("Y-m-d h:i:s", $value['time']);
                            echo $date;
                        ?>
                    </td>
                    <td><?php echo $value['result']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>