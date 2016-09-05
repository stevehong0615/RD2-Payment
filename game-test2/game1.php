<?php
require_once 'model.php';
ini_set('display_errors', true);
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
            $("#btnResult").click(function(){
                $('#resultDiv').load('resultDiv.php');
            });

            $("#btnBet").click(function(){
                var bet1 = $('input[name="bet1"]').val();
                var bet2 = $('input[name="bet2"]').val();
                var bet3 = $('input[name="bet3"]').val();
                $.post('betDiv.php',{bet1:bet1, bet2:bet2, bet3:bet3},function(data){
                    alert('下注成功！');
                });
            })
        });
    </script>
</head>
<body>
<div>
    <form method = "post" action = "result.php" target = "new">
        <input type = "submit" name = "btn" value = "開講號碼">
    </form>
    <?php if ($_SESSION['account'] != "admin") { ?>
        <br><h2>請下注（數字不能重複！）</h2><br>
        請輸入數字：
        <input type = "text" id = "bet1" name = "bet1" value = "">
        請輸入數字：
        <input type = "text" name = "bet2" value = "">
        請輸入數字：
        <input type = "text" name = "bet3" value = "">
        <br>
        <input type = "submit" name = "btnBet" id = "btnBet" value = "確認下注">
    <?php } ?>

    <?php if ($_SESSION['account'] == "admin") { ?>
        <br><h2>點選開獎</h2><br>
        <button type = "submit" id = "btnResult">開獎</button>
        <div id = "resultDiv"></div>
    <?php } ?>
</div>
</body>
</html>
