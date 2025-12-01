<?php

if (isset($_POST['card_generate'])) {
    $seria_key = uniqid('CARD', false);
    $card_name = "Credit Card";
    $card_number = "5276 7547 8976 " . (substr(number_format(time() * rand(), 0, '', ''), 0, 4));
    $card_expiration = "06 / 27";
    $card_security = (substr(number_format(time() * rand(), 0, '', ''), 0, 3));
    $amount = $page['cardfee'];

    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);

    $acct_amount = inputValidation($row['acct_balance']);

    if ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect OTP CODE');
    } else if ($acct_amount < 0) {
        toast_alert('error', 'Insufficient Balance');
    } else {


        $checkUser = $conn->query("SELECT * FROM users WHERE id='$user_id'");
        $result = $checkUser->fetch(PDO::FETCH_ASSOC);

        if ($amount > $result['acct_balance']) {
            toast_alert('error', 'Insufficient Balance');
        } else {




            $available_balance = ($result['acct_balance'] - $amount);

            $sql = "UPDATE users SET acct_balance=:available_balance WHERE id=:user_id";
            $addUp = $conn->prepare($sql);
            $addUp->execute([
                'available_balance' => $available_balance,
                'user_id' => $user_id
            ]);



            $sql2 = "INSERT INTO card SET card_name=:card_name,card_number=:card_number,card_expiration=:card_expiration,card_security=:card_security,user_id=:user_id,seria_key=:seria_key";
            $stmt = $conn->prepare($sql2);
            $stmt->execute([
                'card_name' => $card_name,
                'card_number' => $card_number,
                'card_expiration' => $card_expiration,
                'card_security' => $card_security,
                'user_id' => $user_id,
                'seria_key' => $seria_key
            ]);


            $full_name = $row['firstname'] . " " . $row['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['url_address'];
            $user_email = $row['acct_email'];
            $user_acctno = $row['acct_no'];
            $card_status = "Processing";
            $message = $sendMail->CardMsg($full_name, $card_name, $user_acctno, $amount, $card_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Card Request" . "-" . $APP_NAME;
            $email_message->send_mail($user_email, $message, $subject);

            if (true) {

                toast_alert('success', 'Card Request Successfully', 'Successful');
            } else {
                //   toast_alert('danger', 'Something went wrong!');
            }
        }
    }
}