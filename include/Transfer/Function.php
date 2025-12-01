<?php
require_once __DIR__ . '/../../config.php';
require_once(ROOT_PATH . "/include/config.php");
require_once(ROOT_PATH . "/include/Function/sql.php");
$conn = dbConnect();
$message = new USER();

$viesConn = "SELECT * FROM users WHERE acct_no=:acct_no";
$stmt = $conn->prepare($viesConn);
$stmt->execute([
    ':acct_no' => $_SESSION['acct_no']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $row['id'];


$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);
