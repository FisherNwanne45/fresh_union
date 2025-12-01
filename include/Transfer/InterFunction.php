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
$TransferLimit = 50;

if (isset($_POST['inter-transfer'])) {

    $amount = $_POST['amount'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];


    if ($row['acct_status'] === 'hold') {
        toast_alert("error", "Account on Hold Contact Support");
    } elseif ($amount > $row['acct_balance']) {
        toast_alert("error", "Insufficient Balance!");
    } elseif ($amount < $TransferLimit) {
        toast_alert("error", "Amount too low!");
    } else {
        $refrence_id = uniqid();
        $trans_type = "Interbank transfer";
        $transaction_type = "debit";
        $trans_status = "pending";
        $sql = "INSERT INTO temp_trans (amount,refrence_id,user_id,account_name,account_number,trans_type,transaction_type,trans_status) VALUES(:amount,:refrence_id,:user_id,:account_name,:account_number,:trans_type,:transaction_type,:trans_status)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'user_id' => $user_id,
            'account_name' => $account_name,
            'account_number' => $account_number,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status

        ]);

        if (true) {


            $_SESSION['is_inter_code'] = "None";
            $_SESSION['is_inter_transfer'] = "Inter";
            $_SESSION['is_transfer'] = "None";

            header("Location:./interbank-preview.php");
        }
    }
}



if (isset($_POST['inter-preview'])) {

    $acct_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 4);

    $sql =  "UPDATE users SET acct_otp=:acct_otp WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_otp' => $acct_otp,
        'id' => $user_id
    ]);

    $sql = "SELECT * FROM users WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'id' => $user_id
    ]);

    $resultCode = $stmt->fetch(PDO::FETCH_ASSOC);
    $acct_otp = $resultCode['acct_otp'];

    $number = $resultCode['acct_phone'];


    if ($page['twillio_status'] == '1') {
        $messageText = "Dear " . $resultCode['firstname'] . " You just made a Transaction of $" . $amount . " in Your " . $APP_NAME . " Account  Kindly make use of this " . $acct_otp . "  to complete your Transaction Thanks ";

        $sendSms->sendSmsCode($number, $messageText);
    }

    $full_name = $row['firstname'] . " " . $row['lastname'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $email = $row['acct_email'];

    $message = $sendMail->pinRequest($full_name, $acct_otp, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "One-Time Code - $APP_NAME";
    $email_message->send_mail($email, $message, $subject);

    $_SESSION['is_inter_code'] = "None";
    $_SESSION['is_inter_transfer'] = "Inter";
    $_SESSION['is_transfer'] = "None";

    header("Location:./inter-pin.php");
}
