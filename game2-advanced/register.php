<?php
require_once 'model.php';

if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION['account'] != null) {
    header("location:index.php");
    exit;
}

$en = "/^([0-8A-Za-z]+)$/";

if (isset($_POST['btn'])) {
    $account = $_POST['account'];
    $pwd = md5($_POST['pwd']);
    $balance = 100000;
    $datetime = date("Y-m-d H:i:s");
    $result = searchAccountData($account);

    if (!preg_match($en, $account)) {
        echo "<script>alert('帳號格式錯誤！');</script>";
        header("refresh:0, url=create.php");
        exit;
    }

    if (!preg_match($en, $_POST['pwd'])) {
        echo "<script>alert('密碼格式錯誤！');</script>";
        header("refresh:0, url=create.php");
        exit;
    }

    if ($result[0]['account'] != $account) {
        insertAccount($account, $pwd, $datetime, $balance);

        echo "<script>alert('帳號新增成功！');</script>";
        header("refresh:0, url=login.php");
        exit;
    } else {
        echo "<script>alert('重複的帳號！');</script>";
        header("refresh:0, url=create.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Play Game</title>
    <meta charset = "UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/cufon-yui.js" type="text/javascript"></script>
    <script src="js/ChunkFive_400.font.js" type="text/javascript"></script>
    <script type="text/javascript">
        Cufon.replace('h3',{ textShadow: '1px 1px #000'});
        Cufon.replace('.back');
    </script>
</head>
<body>
<div class="wrapper">
    <div class="content">
        <div id="form_wrapper" class="form_wrapper">
            <form class="login active" method = "post" action = "">
                <h3>Register</h3>
                <div>
                    <label>帳號:</label>
                    <input type="text" name = "account" />
                    <span class="error">This is an error</span>
                </div>
                <div>
                    <label>密碼:</label>
                    <input type="password" name = "pwd" value = "" />
                    <span class="error">This is an error</span>
                </div>
                <div class="bottom">
                    <input type="submit" name = "btn" value="確認註冊" />
                    <a href="login.php" rel="login" class="linkform">回到登入頁面</a>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
</body>
</html>