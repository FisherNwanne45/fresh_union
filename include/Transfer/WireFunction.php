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

$WireLimit = $page['wirelimit'];
$TransferLimit = 50;

if (isset($_POST['wire-transfer'])) {

    $amount = $_POST['amount'];
    $WireFee = $_POST['fee'];
    $account_name = $_POST['account_name'];
    $bank_name = $_POST['bank_name'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $bank_country = $_POST['bank_country'];
    $routine_number = $_POST['routine_number'];
    $description = $_POST['description'];
    $swift_code = $_POST['swift_code'];

    $checkFee = ($amount + $WireFee);

    if ($checkFee > $row['acct_balance']) {
        toast_alert('error', 'Insufficient Balance');
    } elseif ($row['acct_status'] == 'hold') {
        toast_alert('error', 'Account on Hold Contact Support');
    } elseif ($amount > $WireLimit) {
        toast_alert("error", "Transfer Limit Extended!");
    } elseif ($amount < $TransferLimit) {
        toast_alert("error", "Amount too low!");
    } else {
        $refrence_id = uniqid();
        $trans_type = "Wire transfer";
        $transaction_type = "debit";
        $trans_status = "pending";
        $sql = "INSERT INTO temp_trans (amount,refrence_id,description,user_id,bank_name,account_name,account_number,account_type,bank_country,trans_type,transaction_type,trans_status,routine_number,swift_code) VALUES(:amount,:refrence_id,:description,:user_id,:bank_name,:account_name,:account_number,:account_type,:bank_country,:trans_type,:transaction_type,:trans_status,:routine_number,:swift_code)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'description' => $description,
            'user_id' => $user_id,
            'bank_name' => $bank_name,
            'account_name' => $account_name,
            'account_number' => $account_number,
            'account_type' => $account_type,
            'bank_country' => $bank_country,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status,
            'routine_number' => $routine_number,
            'swift_code' => $swift_code

        ]);

        if ($row['billing_code'] == '0') {

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


            $full_name = $resultCode['firstname'] . " " . $resultCode['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['url_address'];
            $email = $resultCode['acct_email'];


            $number = $resultCode['acct_phone'];


            if ($page['twillio_status'] == '1') {
                $messageText = "Dear " . $resultCode['firstname'] . " You just made a Transaction of $" . $amount . " in Your " . $APP_NAME . " Account  Kindly make use of this " . $acct_otp . "  to complete your Transaction Thanks ";

                $sendSms->sendSmsCode($number, $messageText);
            }
            $message = $sendMail->pinRequest($full_name, $acct_otp, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "One-Time Code - $APP_NAME";
            $email_message->send_mail($email, $message, $subject);

            if (true) {
                $_SESSION['wire-transfer'] = $user_id;
                $_SESSION['is_wire_transfer'] = "wire";
                $_SESSION['is__transfer'] = "None";
                $_SESSION['is_transfer']  = "transfer";
                $_SESSION['is_tax_code'] = "None";

                header("Location:./wire-pin-preview.php");
            }
        } elseif ($row['billing_code'] == '2') {

            $_SESSION['is_wire_code'] = "None";
            $_SESSION['is_wire_transfer'] = "Wire";
            $_SESSION['is_transfer'] = "None";
            header("Location:./transfer-preview.php");
        } elseif ($row['billing_code'] == '3') {

            $_SESSION['is_wire_code'] = "None";
            $_SESSION['is_wire_transfer'] = "Wire";
            $_SESSION['is_transfer'] = "None";
            header("Location:./wire-pincode-preview.php");
        } else {

            $_SESSION['is_wire_code'] = "None";
            $_SESSION['is_wire_transfer'] = "Wire";
            $_SESSION['is_transfer'] = "None";
            header("Location:./wire-preview.php");
        }
    }
}

if (isset($_POST['save_beneficiary']) && $_POST['save_beneficiary'] == 'on') {
    try {
        $stmt = $conn->prepare("INSERT INTO beneficiaries (user_id, account_number, bank_name, account_name, country, account_type) 
                               VALUES (:user_id, :account_number, :bank_name, :account_name, :country, :account_type)");
        $stmt->execute([
            'user_id' => $user_id,
            'account_number' => $_POST['account_number'],
            'bank_name' => $_POST['bank_name'],
            'account_name' => $_POST['account_name'],
            'country' => $_POST['bank_country'],
            'account_type' => $_POST['account_type']
        ]);
    } catch (Exception $e) {
        // Silent fail - don't interrupt the transfer if beneficiary save fails
    }
}

if (isset($_POST['wire-preview'])) {


    if ($page['cot_code'] == '0') {


        $_SESSION['wire-transfer'] = $user_id;
        $_SESSION['is_cot_code'] = "Cot";
        $_SESSION['is_transfer']  = "transfer";


        header("Location:./tax.php");
    } else {

        $_SESSION['is_wire_code'] = "None";
        $_SESSION['is_wire_transfer'] = "Wire";
        $_SESSION['is_transfer'] = "None";

        header("Location:./cot.php");
    }
}

if (isset($_POST['wire-pin-preview'])) {

    header("Location:./wire-pin.php");
}

if (isset($_POST['wire-pincode-preview'])) {

    header("Location:./pincode.php");
}

if (isset($_POST['transfer-preview'])) {


    if ($page['cot_code'] == '0') {


        $_SESSION['wire-transfer'] = $user_id;
        $_SESSION['is_cot_code'] = "Cot";
        $_SESSION['is_transfer']  = "transfer";


        header("Location:./code2.php");
    } else {

        $_SESSION['is_wire_code'] = "None";
        $_SESSION['is_wire_transfer'] = "Wire";
        $_SESSION['is_transfer'] = "None";

        header("Location:./code1.php");
    }
}