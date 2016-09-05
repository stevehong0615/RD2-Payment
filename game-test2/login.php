<?php
require_once 'model.php';
ini_set('display_errors', true);
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
    <meta charset = "UTF-8">
    <title>登入帳號</title>
</head>
<body>
<div align = "center">
    <a href="create.php" title="新增帳號">新增帳號</a>
    <p>
    <form method = "post" action = "">
        帳號：
        <input type = "text" name = "account" value = "">
        <br><br>
        密碼：
        <input type = "password" name = "pwd" value = "">
        <br><br>
        <input type = "submit" name = "btn" value = "登入">
    </form>
</div>
</body>
</html>
