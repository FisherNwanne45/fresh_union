<?php
require_once __DIR__ . '/../../config.php';
require_once(ROOT_PATH . "/include/config.php");
require_once(ROOT_PATH . "/include/Function/userClass.php");
require_once(ROOT_PATH . "/include/Function/Function.php");
require_once ROOT_PATH . "/include/SMS/twilioController.php";

$conn = dbConnect();
$message = new message();

$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $page['url_name'];


$url_email = $page['url_email'];

$viesConn = "SELECT * FROM users WHERE acct_no=:acct_no";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
    ':acct_no' => $_SESSION['acct_no']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $row['id'];


$acct_stat = $row['acct_status'];

// show balance 6,78.76
$acct_balance = $row['acct_balance'];
$transferLimit = $row['limit_remain'];
$loan_balance = $row['loan_balance'];

$fullName = $row['firstname'] . " " . $row['lastname'];
$email = $row['acct_email'];

// $currency = $page['currency'];
$currency = $row['acct_currency'];

//USER STATUS
function userStatus($row)
{
    if ($row['acct_status'] === 'active') {
        return 'ACTIVE';
    }

    if ($row['acct_status'] === 'hold') {
        return 'ON HOLD';
    }
}


$userStatus = userStatus($row);
