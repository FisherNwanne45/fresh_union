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

$DomesticLimit = $page['domesticlimit'];
$TransferLimit = 50;

// -------------------------------------------
// DOMESTIC TRANSFER SUBMISSION
// -------------------------------------------
if (isset($_POST['domestic-transfer'])) {

    $amount = $_POST['amount'];
    $DomesticFee = $_POST['fee'];
    $account_name = $_POST['account_name'];
    $bank_name = $_POST['bank_name'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $bank_country = $_POST['bank_country'];
    $description = $_POST['description'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $APP_EMAIL = WEB_EMAIL;

    $checkFee = ($amount + $DomesticFee);

    if ($checkFee > $row['acct_balance']) {
        toast_alert('error', 'Insufficient Balance');
    } elseif ($row['acct_status'] == 'hold') {
        toast_alert('error', 'Account on Hold Contact Support');
    } elseif ($amount > $DomesticLimit) {
        toast_alert("error", "Transfer Limit Extended!");
    } elseif ($amount < $TransferLimit) {
        toast_alert("error", "Amount too low!");
    } else {

        // Insert the transaction
        $refrence_id = uniqid();
        $trans_type = "Domestic transfer";
        $transaction_type = "debit";
        $trans_status = "pending";

        $sql = "INSERT INTO temp_trans 
                (amount,refrence_id,user_id,bank_name,account_name,account_number,
                 account_type,bank_country,trans_type,transaction_type,description,
                 trans_status)
                VALUES
                (:amount,:refrence_id,:user_id,:bank_name,:account_name,:account_number,
                 :account_type,:bank_country,:trans_type,:transaction_type,:description,
                 :trans_status)";

        $select_user_sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $conn->prepare($select_user_sql);
        $stmt->execute([
            'id' => $user_id
        ]);
        $resultCodes = $stmt->fetch(PDO::FETCH_ASSOC);


        $full_name = $resultCodes['firstname'] . " " . $resultCodes['lastname'];

        $message = $sendMail->userDomSend($full_name, $account_name, $bank_country, $amount, $APP_NAME, $account_number, $trans_type, $description);
        // User Email
        $subject = "User Transfer Notification - $APP_NAME";
        $email_message->send_mail($APP_EMAIL, $message, $subject);

        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'user_id' => $user_id,
            'bank_name' => $bank_name,
            'account_name' => $account_name,
            'account_number' => $account_number,
            'account_type' => $account_type,
            'bank_country' => $bank_country,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'description' => $description,
            'trans_status' => $trans_status
        ]);

        // -------------------------------------------
        // BILLING CODE LOGIC (MIRRORS WIRE FUNCTION)
        // -------------------------------------------
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
                $_SESSION['domestic-transfer'] = $user_id;
                $_SESSION['is_dom_transfer'] = "wire";
                $_SESSION['is__transfer'] = "None";
                $_SESSION['is_transfer']  = "transfer";
                $_SESSION['is_tax_code'] = "None";

                header("Location:./dom-pin-preview.php");
            }
        } elseif ($row['billing_code'] == '2') {

            // NEW DOM PAGE
            $_SESSION['is_dom_code'] = "None";
            $_SESSION['is_dom_transfer'] = "Dom";
            $_SESSION['is_transfer'] = "None";

            header("Location: ./dom-transfer-preview.php");
            exit;
        } elseif ($row['billing_code'] == '3') {

            // NEW DOM PINCODE PAGE
            $_SESSION['is_dom_code'] = "None";
            $_SESSION['is_dom_transfer'] = "Dom";
            $_SESSION['is_transfer'] = "None";

            header("Location: ./dom-pincode-preview.php");
            exit;
        } else {

            // DEFAULT / ORIGINAL PAGE
            $_SESSION['is_dom_transfer'] = "Dom";
            $_SESSION['is_dom_code'] = "None";
            $_SESSION['is_transfer'] = "None";

            header("Location: ./domestic-preview.php");
            exit;
        }
    }
}

// -------------------------------------------
// SAVE BENEFICIARY (same as before)
// -------------------------------------------
if (isset($_POST['save_beneficiary']) && $_POST['save_beneficiary'] == 'on') {
    try {
        $stmt = $conn->prepare("INSERT INTO beneficiaries 
            (user_id, account_number, bank_name, account_name, country, account_type) 
            VALUES 
            (:user_id, :account_number, :bank_name, :account_name, :country, :account_type)");

        $stmt->execute([
            'user_id' => $user_id,
            'account_number' => $_POST['account_number'],
            'bank_name' => $_POST['bank_name'],
            'account_name' => $_POST['account_name'],
            'country' => $_POST['bank_country'],
            'account_type' => $_POST['account_type']
        ]);
    } catch (Exception $e) {
    }
}
if (isset($_POST['domestic-preview'])) {

    if ($page['cot_code'] == '0') {

        $_SESSION['domestic-transfer'] = $user_id;
        $_SESSION['is_cot_code'] = "Cot";
        $_SESSION['is_transfer']  = "transfer";

        header("Location:./dom-tax.php");
    } else {

        $_SESSION['is_dom_code'] = "None";
        $_SESSION['is_dom_transfer'] = "Dom";
        $_SESSION['is_transfer'] = "None";

        header("Location:./dom-cot.php");
    }
}


if (isset($_POST['dom-pin-preview'])) {
    header("Location:./dom-pin.php");
}
if (isset($_POST['dom-pincode-preview'])) {
    header("Location:./dom-pincode.php");
}

if (isset($_POST['dom-transfer-preview'])) {


    if ($page['cot_code'] == '0') {


        $_SESSION['domestic-transfer'] = $user_id;
        $_SESSION['is_cot_code'] = "Cot";
        $_SESSION['is_transfer']  = "transfer";


        header("Location:./dom-code2.php");
    } else {

        $$_SESSION['is_dom_code'] = "None";
        $_SESSION['is_dom_transfer'] = "Dom";
        $_SESSION['is_transfer'] = "None";

        header("Location:./dom-code1.php");
    }
}