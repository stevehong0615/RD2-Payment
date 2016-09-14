<?php
require_once 'model.php';

if (!isset($_SESSION)) {
    session_start();
}
$account = $_SESSION['account'];


if ($_SESSION['account'] == null) {
    header("location:login.php");
    exit;
}

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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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

    $(document).ready(function(){
        function getTotal(){
            $.ajax({
                type:"GET",
                url:"balance.php",
                success:function(data){
                $("#joinLiveCount").text(data);
            }
            });
        }
        getTotal();
    });
    </script>
</head>
<body style = "font-size:180%;" background = "images/White.jpg">
<div class = "container">
    <div class = "row">
        <div class = "col-lg-2"></div>
        <div class = "col-lg-8">
            <h1>機率與命運</h1>
        </div>
    </div>
    <div class = "row">
        <div class = "col-lg-2"></div>
        <div class = "col-lg-7"><img src = "images/lotto.jpg" class = "img-circle" alt = "Cinque Terre" width = "500" height = "139"></div>
        <div class = "col-lg-3">
            <form method = "post" action = "">
                <input type = "submit" name = "logout" value = "登出" class="btn btn-primary">
            </form>

            帳號：<?php echo $_SESSION['account']; ?>
            <br>
            額度：<font id = "joinLiveCount" ></font> 元
            <br>
            <form method = "post" action = "log.php" target = "new">
                <input type = "submit" name = "btn" value = "下注歷史" class = "btn btn-primary">
            </form>
        </div>
    </div>
    <br>
    <div class = "row">
        <div class = "col-lg-2"></div>
        <div class = "col-lg-8">
            <button id = "game1" type = "button" class = "btn btn-primary btn-lg">二字遊戲</button>
            <button id = "game2" type = "button" class = "btn btn-primary btn-lg">三字遊戲</button>
        </div>
        <div class = "col-lg-2"></div>
    </div>
    <hr>
    <div class = "row">
        <div class = "col-lg-2"></div>
        <div class = "col-lg-8">
            <div id = "gameDiv"><h2>歡迎光臨！ 請選擇您要玩的遊戲！</h2></div>
        </div>
        <div class = "col-lg-2"></div>
    </div>
</div>
</body>
</html>