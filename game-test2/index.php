<?php
require_once 'model.php';
ini_set('display_errors', true);
session_start();

if ($_SESSION['account'] == null) {
    header("location:login.php");
    exit;
}

$balance = searchAccountData($_SESSION['account']);
$balance = $balance[0]['balance'];

if (isset($_POST['logout'])) {
    session_destroy();
    header("location:login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>PlayGame</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#game1").click(function(){
                $('#gameDiv').load('game1.php');
            });
            $("#game2").click(function(){
                $('#gameDiv').load('game2.php');
            });
        });
    </script>
</head>
<body>
<div>
    <form method = "post" action = "">
        <input type = "submit" name = "logout" value = "登出">
    </form>
    帳號：<?php echo $_SESSION['account']; ?>
    <br>
    額度：<?php echo $balance . "元" ?>
    <br>
    <form method = "post" action = "log.php" target = "new">
        <input type = "submit" name = "btn" value = "下注歷史">
    </form>
    <button id = "game1" type = "button">二字遊戲</button>
    <button id = "game2" type = "button">三字遊戲</button>
    <hr>
    <div id = "gameDiv"><h2>歡迎光臨！ 請選擇您要玩的遊戲！</h2></div>
</div>
</body>
</html>
