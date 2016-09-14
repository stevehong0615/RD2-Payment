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
//            $("#btnBet").click(function(){
//                var money = $('input[name = "money"]').val();
//                var bet1 = $('input[name = "bet1"]').val();
//                var bet2 = $('input[name = "bet2"]').val();
//                var bet3 = $('input[name = "bet3"]').val();
//                $.post('betDiv.php',{bet1:bet1, bet2:bet2, bet3:bet3},function(data){
//                    $('#joinLiveCount').text(data);
//                    alert('下注成功！');
//                });
//            });

            $('#betResultDiv').load('result.php');
            timer();


            function timer()
            {
                $.get("computeTime.php", function(data){

                    $('#showtime').text(data);
                    $('#betResultDiv').load('result.php');
                    if(data >= 0){
                        setTimeout(function() {
                            timer();
                        }, 1000);
                    }
/*
                    if (data == '本日尚未開獎！') {
                        $('#showtime').text(data);
                    }else if (data < 0 ) {
                        $('#showtime').text('本日開獎結束！');
                    } else {
                        $('#showtime').text(data);
                        $('#betResultDiv').load('result.php');

                        setTimeout(function() {
                            timer();
                        }, 1000);
                    }*/
                });
            }

//            function counter(sec){
//                sec--;
//                $('#showtime').text(sec);
//
//                if (sec > 0) {
//                    setTimeout(function(){
//                        counter(sec);
//                    }, 1000);
//                }
//                if (sec <= 0) {
//                    $('#betResultDiv').load('result.php');
//                    setTimeout(function() {
//                        timer();
//                    }, 1000);
//                }
//            }
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
    <input type = "text" name = "money" value = ""><br><br>
    輸入數字：
    <input type = "text" name = "bet1" value = ""><br>
    輸入數字：
    <input type = "text" name = "bet2" value = ""><br>
    輸入數字：
    <input type = "text" name = "bet3" value = "">
    <br><br>
    <input type = "submit" name = "btnBet" id = "btnBet" value = "確認下注" class="btn btn-primary btn-lg btn-block">
</div>
</body>
</html>
