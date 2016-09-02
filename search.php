<?php
require_once 'connect.php';
$en = "/^([0-8A-Za-z]+)$/";

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

if (isset($_POST['btn'])) {
    $account = $_POST['searchAccount'];
    $result = searchData($account);
    if (!preg_match($en, $account)) {
        echo "<script>alert('帳號格式錯誤！');</script>";
        header("refresh:0, url=index.php");
    } else {
        if ($result[0]['account'] == null) {
            echo "<script>alert('無效的帳號！');</script>";
        } else {
            $data = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title><?php echo $data[0]['account']; ?>帳號明細</title>
</head>
<body>
<table style="border:3px #FFAC55 double;padding:5px;" rules="all" cellpadding='5';>
    <tr>
        <th>帳號</th>
        <th>動作</th>
        <th>日期時間</th>
        <th>金額</th>
        <th>餘額</th>
    </tr>
    <?php foreach ($data as $value) { ?>
    <tr>
        <td><?php echo $value['account']; ?></td>
        <td><?php echo $value['actionDo']; ?></td>
        <td><?php echo $value['datetime']; ?></td>
        <td><?php echo $value['money']; ?></td>
        <td><?php echo $value['balance']; ?></td>
    </tr>
<?php } ?>
</table>
</body>
</html>
