<?php


$pageName  = "Forgot Password";
include_once(ROOT_PATH . "/auth/header.php");
if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
}

if (isset($_POST['send-link'])) {
    $email = inputValidation($_POST['email']);
    $log = "SELECT * FROM users WHERE acct_email ='$email'";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $validAcct_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($validAcct_email, FILTER_VALIDATE_EMAIL)) {
        toast_alert("error", "Invalid email address please type a valid email address!");
    } elseif ($user['acct_email'] == "") {
        toast_alert("error", "No user is registered with this email address!");
    } else {

        $reset_token = bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d");

        $sql = "UPDATE users SET resettoken=:reset_token,resettokenexp=:date WHERE acct_email=:email";
        $addUp = $conn->prepare($sql);
        $addUp->execute([
            'reset_token' => $reset_token,
            'date' => $date,
            'email' => $email
        ]);

        if (true) {
            $full_name = $user['firstname'] . " " . $user['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['url_address'];
            $APP_NUMBER = WEB_PHONE;
            $APP_EMAIL = WEB_EMAIL;
            $user_email = $user['acct_email'];
            $user_acctno = $user['acct_no'];
            $message = $sendMail->ForgotMsg($full_name, $email, $user_acctno, $reset_token, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Password Reset" . "-" . $APP_NAME;
            $email_message->send_mail($user_email, $message, $subject);

            toast_alert("success", "Password reset link sent to email", "Thanks!");
        } else {
            toast_alert("error", "Sorry Something Went Wrong !");
        }
    }
}





?>


<!-- App Header -->
<div class="appHeader no-border transparent position-absolute">
    <div class="left">

    </div>
    <div class="pageTitle"></div>
    <div class="right">
    </div>
</div>
<!-- * App Header -->


<div id="appCapsule">

    <div class="authincation section-padding">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="section mt-3">


                    <div class="section mt-3">
                        <div class="card">
                            <div class="card-body">
                                <p>Please type in the email address linked to your <?= $pageTitle ?> account to reset your password.</p>
                            </div>
                        </div>
                    </div><br>

                    <div class="section mt-3">
                        <div class="card">
                            <div class="card-body">

                                <div class="tab-content mt-1">
                                    <div class="tab-pane fade show active" id="wema" role="tabpanel">

                                        <!-- card block -->
                                        <div class="card-body">
                                            <center>
                                                <div id="google_translate_element"></div>
                                            </center><br>
                                            <form method="post" class="signin_validate row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" maxlength="60" class="form-control" placeholder="example@gmail.com" name="email" />
                                                </div>

                                                <div class="mt-3 mb-0">
                                                    <a href="./login.php">Remember Password?</a>
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <button type="submit" name="send-link" class="btn btn-primary" style="background-color:#1F1B44;">
                                                        Reset
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                        <!-- * card block -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <ul class="listview image-listview text inset no-line">
                        <li>
                            <div class="item">
                                <div class="in">
                                    <div>
                                        Theme Mode
                                    </div>
                                    <div class="form-check form-switch  ms-2">
                                        <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodeSwitch">
                                        <label class="form-check-label" for="darkmodeSwitch"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

</div>

<?php

include_once(ROOT_PATH . "/auth/footer.php");

?>