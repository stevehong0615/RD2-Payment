<?php
require_once 'model.php';
ini_set('display_errors', true);
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>二字遊戲</title>
</head>
<body>
<div>
    <form method = "post" action = "result.php" target = "new">
        <input type = "submit" name = "btn" value = "開講號碼">
    </form>
    <form method = "post" action = "">
        請輸入數字：
        <input type = "text" name = "bet1" value = "">
        請輸入數字：
        <input type = "text" name = "bet2" value = "">
        請輸入數字：
        <input type = "text" name = "bet3" value = "">
        <br>
        <input type = "submit" name = "btnBet" value = "確認下注">
    </form>

    <?php if ($_SESSION['account'] == "steve") { ?>
        <form>
            <input type = "submit" name = "btnResult" value = "開獎">
        </form>
    <?php } ?>
</div>
</body>
</html>
