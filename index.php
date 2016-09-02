<?php
require_once 'connect.php';
ini_set ('display_errors', true);
$en = "/^([0-8A-Za-z]+)$/";

function insertData($account, $actionDo, $datetime, $money, $balance)
{
    $connect = new Connect;

    $sql = "INSERT INTO `payment_data`
        (`account`, `actionDo`, `datetime`, `money`, `balance`)
        VALUES (:account, :actionDo, :datetime, :money, :balance)";

    $addData = $connect->db->prepare($sql);
    $addData->bindParam(':account', $account);
    $addData->bindParam(':actionDo', $actionDo);
    $addData->bindParam(':datetime', $datetime);
    $addData->bindParam(':money', $money);
    $addData->bindParam(':balance', $balance);
    $addData->execute();
}

function searchData($account)
{
    $connect = new Connect;

    $sql = "SELECT * FROM `payment_data` WHERE `account` = :account";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();

    return $result;
}

function searchBalance($account)
{
    $connect = new Connect;

    $sql = "SELECT `balance` FROM `payment_data` WHERE `account` = :account ORDER BY `id` DESC FOR UPDATE";

    $data = $connect->db->prepare($sql);
    $data->bindParam(':account', $account);
    $data->execute();
    $result = $data->fetchAll();
    $result = $result[0]['balance'];

    return $result;
}

if (isset($_POST['btnAccount'])) {
    $account = $_POST['addAccount'];
    $money = $_POST['addMoney'];
    $actionDo = "開戶";
    $datetime = date("Y-m-d H:i:s");
    $balance = $money;
    $result = searchData($account);

    if (!preg_match($en, $account)) {
        echo "<script>alert('帳號格式錯誤！');</script>";
        header("refresh:0, url=index.php");
    } else {
        if ($result[0]['account'] != $account) {
            insertData($account, $actionDo, $datetime, $money, $balance);

            echo "<script>alert('帳號新增成功！');</script>";
        } else {
            echo "<script>alert('重複的帳號！');</script>";
        }
    }
}

if (isset($_POST['btnWithDraw'])) {
    $account = $_POST['transAccount'];
    $actionDo = "出款";
    $datetime = date("Y-m-d H:i:s");
    $money = $_POST['transMoney'];
    $result = searchData($account);

    if (!preg_match($en, $account)) {
        echo "<script>alert('帳號格式錯誤！');</script>";
        header("refresh:0, url=index.php");
    } else {
        if ($result[0]['account'] == null) {
            echo "<script>alert('無效的帳號！');</script>";
        } else {
            if (searchBalance($account) >= $money) {
                $connect = new Connect;

                try {
                    $connect->db->beginTransaction();
                    $balance = searchBalance($account);
                    $balance -= $money;
                    insertData($account, $actionDo, $datetime, $money, $balance);
                    $connect->db->commit();
                } catch (Exception $err) {
                    $connect->db->rollBack();
                    $msg = $err->getMessage();
                    echo $msg;
                }
                echo "<script>alert('成功轉出！');</script>";
            } else {
                echo "<script>alert('餘額不足！');</script>";
            }
        }
    }
}

if (isset($_POST['btnDeposit'])) {
    $account = $_POST['transAccount'];
    $actionDo = "入款";
    $datetime = date("Y-m-d H:i:s");
    $money = $_POST['transMoney'];
    $result = searchData($account);

    if (!preg_match($en, $account)) {
        echo "<script>alert('帳號格式錯誤！');</script>";
        header("refresh:0, url=index.php");
    } else {
        if ($result[0]['account'] == null) {
            echo "<script>alert('無效的帳號！');</script>";
        } else {
            $balance = searchBalance($account);
            $balance += $money;
            insertData($account, $actionDo, $datetime, $money, $balance);

            echo "<script>alert('成功轉入！');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>Payment</title>
</head>
<body>
<form method = "post" action = "">
    新增帳號：
    <input type = "text" name = "addAccount" value = "">
    輸入金額：
    <input type = "text" name = "addMoney" value = "" pattern = "[0-9]{1,15}">
    <input type = "submit" name = "btnAccount" value = "新增帳號">
</form>
<form method = "post" action = "">
    輸入帳號：
    <input type = "text" name = "transAccount" value = "">
    輸入金額：
    <input type = "text" name = "transMoney" value = "" pattern = "[0-9]{1,15}">
    <input type = "submit" name = "btnWithDraw" value = "出款">
    <input type = "submit" name = "btnDeposit" value = "存款">
</form>
<br/>
<form method = "post" action = "search.php" target = "new">
    輸入帳號：
    <input type = "text" name = "searchAccount" value = "">
    <input type = "submit" name = "btn" value = "明細查詢">
</form>
</body>
</html>