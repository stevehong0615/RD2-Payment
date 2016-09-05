<?php
require_once 'connect.php';
if (!isset($_SESSION)) {
    session_start();
}

$account = $_SESSION['account'];

$connect = new Connect;

$sql = "SELECT `balance` FROM `account_data` WHERE `account` = :account";

$data = $connect->db->prepare($sql);
$data->bindParam(':account', $account);
$data->execute();
$result = $data->fetchAll();
$result = $result[0]['balance'];
echo $result;
