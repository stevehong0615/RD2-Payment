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
    $result = searchAccountData($account);

    if (!preg_match($en, $account)) {
        echo "<script>alert('帳號格式錯誤！');</script>";
        header("refresh:0, url=login.php");
        exit;
    }

    if (!preg_match($en, $_POST['pwd'])) {
        echo "<script>alert('密碼格式錯誤！');</script>";
        header("refresh:0, url=login.php");
        exit;
    }

    if ($result[0]['account'] != $account) {
        echo "<script>alert('無效的帳號！');</script>";
        header("refresh:0, url=login.php");
        exit;
    }

    if ($result[0]['account'] == $account && $result[0]['password'] == $pwd) {
        $_SESSION['account'] = $result[0]['account'];
        echo "<script>alert('登入成功！');</script>";
        header("refresh:0, url=index.php");
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
                <h3>Login</h3>
                <div>
                    <label>帳號:</label>
                    <input type="text" name = "account" />
                    <span class="error">This is an error</span>
                </div>
                <div>
                    <label>密碼: </label>
                    <input type="password" name = "pwd" />
                    <span class="error">This is an error</span>
                </div>
                <div class="bottom">
                    <input type="submit" name = "btn" value="登入"></input>
                    <a href="register.php" rel="register" class="linkform">註冊帳號</a>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
</body>
</html>