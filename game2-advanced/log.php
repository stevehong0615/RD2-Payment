<?php
require_once 'model.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location:login.php");
    exit;
}

if (isset($_POST['btnSerial'])) {
    $serial = $_POST['serial'];

    $result = searchSerialResult($serial);
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
    <div class = "row">
        <div class = "col-lg-10"></div>
        <div class = "col-lg-2">
            <form method = "post" action = "">
                <input type = "submit" name = "logout" value = "登出" class="btn-primary">
            </form>
        </div>
    </div>
    <div class = "row">
        <div class = "col-lg-10"></div>
        <div class = "col-lg-2">
            帳號：<?php echo $account; ?>
        </div>
    </div>
    <div class = "table-responsive">
        <form method = "post" action = "">
            <input type = "text" name = "serial" value = "例：2016-09-19 - 001">
            <input type = "submit" name = "btnSerial" value = "搜尋">
        </form>
        <table class = "table">
            <tr>
                <th>開獎期號</th>
                <th>開獎號碼</th>
                <th>開獎時間</th>
            </tr>
            <tr>
                <?php if (isset($_POST['btnSerial'])) { ?>
                    <td><?php echo $result['serial']; ?></td>
                    <td>
                        <?php
                            $bet = $result['bet_result'];
                            $bet = json_decode($bet, true);
                            echo $bet[0] . $bet[1] . $bet[2];
                        ?>
                    </td>
                    <td><?php echo $result['updatetime']; ?></td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <hr>
    <div class = "table-responsive">
        <table class = "table">
            <tr>
                <th>兌獎期號</th>
                <th>下注內容</th>
                <th>金額</th>
                <th>日期</th>
                <th>輸贏</th>
                <th>輸贏金額</th>
            </tr>
            <?php foreach ($data as $value) { ?>
                <tr>
                    <td><?php echo $value['serial']; ?></td>
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