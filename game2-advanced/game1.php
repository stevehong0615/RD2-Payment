<?php
require_once 'model.php';

if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>二字遊戲</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btnBet").click(function(){
                var money = $('input[name = "money"]').val();
                var bet1 = $('input[name = "bet1"]').val();
                var bet2 = $('input[name = "bet2"]').val();
                var bet3 = $('input[name = "bet3"]').val();
                $.post('betDiv.php',{money:money, bet1:bet1, bet2:bet2, bet3:bet3},function(data){
                    $('#joinLiveCount').text(data);
                    alert('下注成功！');
                });
            });

            $("#btnBet").hide();
            $('#betResultDiv').load('result.php');
            timer();

            function timer()
            {
                $.get("computeTime.php", function (data)
                {
                    var data = $.parseJSON(data);

                    console.log(data);
                    var msg = data.msg.replace("{sec}", data.sec);

                    $('#showtime').text(msg);
                    $('#betResultDiv').load('result.php');
                    if (data.sec >=10 && data.sec <= 30) {
                        $("#money").removeAttr("disabled");
                        $("#bet1").removeAttr("disabled");
                        $("#bet2").removeAttr("disabled");
                        $("#bet3").removeAttr("disabled");
                        $("#btnBet").show();
                    } else {
                        $("#money").attr("disabled","disabled");
                        $("#bet1").attr("disabled","disabled");
                        $("#bet2").attr("disabled","disabled");
                        $("#bet3").attr("disabled","disabled");
                        $("#btnBet").hide();
                    }
                    if (data.sec >= 0) {
                        setTimeout(function()
                        {
                            timer();
                        }, 1000);
                    }
                });
            }
        });
    </script>
</head>
<body>
<h2>歡迎光臨二字遊戲</h2>
<br>
<div id = 'showtime'></div>
<br>
<div id = 'betResultDiv'></div>
<div>
    <h2>請下注！</h2><br>
    下注金額：
    <input type = "text" name = "money" id = "money" value = "" disabled = "disabled"><br><br>
    輸入數字：
    <input type = "text" size = "3" name = "bet1" id = "bet1" value = "" disabled = "disabled">
    輸入數字：
    <input type = "text" size = "3" name = "bet2" id = "bet2" value = "" disabled = "disabled">
    輸入數字：
    <input type = "text" size = "3" name = "bet3" id = "bet3" value = "" disabled = "disabled">
    <br><br>
    <input type = "submit" name = "btnBet" id = "btnBet" value = "確認下注" class="btn btn-primary btn-lg btn-block" >
</div>
</body>
</html>
