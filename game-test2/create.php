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
    $balance = $_POST['money'];
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
    <meta charset = "UTF-8">
    <title>新增帳號</title>
</head>
<body>
<div align = "center">
    <a href="login.php" title="登入帳號">登入帳號</a>
    <p>
    <form method = "post" action = "">
        帳號：
        <input type = "text" name = "account" value = "">
        <br><br>
        密碼：
        <input type = "password" name = "pwd" value = "">
        <br><br>
        金額：
        <input type = "text" name = "money" value = "" pattern = "[0-9]{1,15}">
        <br><br>
        <input type = "submit" name = "btn" value = "新增帳號">
    </form>
</div>
</body>
</html>