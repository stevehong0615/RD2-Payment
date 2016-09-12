<?php
ignore_user_abort(true);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>setTimeout</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btn").click(function(){
                $('#gameDiv').load('lottery.php');
                timer();
            });

            function counter(sec){
                sec--;
                $('#showtime').text(sec);
                if (sec <= 0) {
                    $('#gameDiv').load('lottery.php');
                    setTimeout(timer, 1000);
                } else {
                    setTimeout(function () {
                        counter(sec);
                    }, 1000);
                }
            }

            function timer(){
                $.get("database.php",function(data){
                    if (data == '本日結束！') {
                        $('#showtime').text(data);
                    } else {
                        counter(data);
                    }
                });
            }

        });
    </script>
</head>
<body>
<input type = "submit" name = "btn" id = "btn" value = "開獎">
<div id = 'gameDiv'></div>
<div id = 'showtime'></div>
</body>
</html>
