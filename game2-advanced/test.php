<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
        var c=0
        var t
        function timedCount()
        {
            document.getElementById('txt').value=c
            c=c+1
            t=setTimeout("timedCount()",1000)
        }
    </script>
</head>

<body>

<form>
    <input type="button" value="开始计时！" onClick="timedCount()">
    <input type="text" id="txt">
</form>

<p>请点击上面的按钮。输入框会从 0 开始一直进行计时。</p>

</body>

</html>


<?php
$aa = $_GET['aa'];
echo $aa;
?>
