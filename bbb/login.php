<?php


$pageName  = "Login";
include_once(ROOT_PATH . "/auth/loghead.php");
if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
}


if (isset($_POST['login'])) {
    $acct_no = inputValidation($_POST['acct_no']);
    $acct_password = inputValidation($_POST['acct_password']);
    $log = "SELECT * FROM users WHERE acct_no =:acct_no";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'acct_no' => $acct_no
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        toast_alert("error", "Invalid login details");
    } else {
        $validPassword = password_verify($acct_password, $user['acct_password']);
        if ($validPassword === false) {
            toast_alert("error", "Invalid login details");
        } else {
            if ($user['acct_status'] === 'hold') {
                toast_alert("error", "Account on Hold, Kindly contact support to activate your account");
            } else {
                if (true) {

                    $number = $user['acct_phone'];
                    $full_name = $user['firstname'] . " " . $user['lastname'];
                    $APP_NAME = WEB_TITLE;
                    if ($page['twillio_status'] == '1') {
                        $messageText = "Dear " . $full_name . ", New Login Notification " . $APP_NAME . ".";

                        $sendSms->sendSmsCode($number, $messageText);
                    }

                    $full_name = $user['firstname'] . " " . $user['lastname'];
                    $APP_NAME = WEB_TITLE;
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['url_address'];
                    $APP_NUMBER = WEB_PHONE;
                    $APP_EMAIL = WEB_EMAIL;
                    $user_email = $user['acct_email'];
                    $user_acctno = $user['acct_no'];
                    $message = $sendMail->LoginMsg($full_name, $user_acctno, $APP_NAME, $APP_NUMBER, $APP_EMAIL, $APP_URL, $SITE_ADDRESS);
                    // User Email
                    $subject = "Login Notification" . "-" . $APP_NAME;
                    //$email_message->send_mail($user_email, $message, $subject);
                    $_SESSION['login'] = $user['acct_no'];
                    header("Location:./pin.php");
                    exit;
                }
            }
        }
    }
}

if (isset($_POST['emaillogin'])) {
    $acct_email = inputValidation($_POST['acct_email']);
    $acct_password = inputValidation($_POST['acct_password']);
    $log = "SELECT * FROM users WHERE acct_email =:acct_email";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'acct_email' => $acct_email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() === 0) {
        toast_alert("error", "Invalid login details");
    } else {
        $validPassword = password_verify($acct_password, $user['acct_password']);

        if ($validPassword === false) {

            toast_alert("error", "Invalid login details");
        } else {

            if ($user['acct_status'] === 'hold') {
                toast_alert("error", "Account on Hold, Kindly contact support to activate your account");
            } else {

                if (true) {

                    $number = $user['acct_phone'];
                    $full_name = $user['firstname'] . " " . $user['lastname'];
                    $APP_NAME = WEB_TITLE;
                    if ($page['twillio_status'] == '1') {
                        $messageText = "Dear " . $full_name . ", New Login Notification " . $APP_NAME . ".";

                        $sendSms->sendSmsCode($number, $messageText);
                    }

                    $full_name = $user['firstname'] . " " . $user['lastname'];
                    $APP_NAME = WEB_TITLE;
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['url_address'];
                    $APP_NUMBER = WEB_PHONE;
                    $APP_EMAIL = WEB_EMAIL;
                    $user_email = $user['acct_email'];
                    $user_acctno = $user['acct_no'];
                    $message = $sendMail->LoginMsg($full_name, $user_acctno, $APP_NAME, $APP_NUMBER, $APP_EMAIL, $APP_URL, $SITE_ADDRESS);
                    // User Email
                    $subject = "Login Notification" . "-" . $APP_NAME;
                    $email_message->send_mail($user_email, $message, $subject);
                    $_SESSION['login'] = $user['acct_no'];
                    header("Location:./pin.php");
                    exit;
                }
            }
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
                            <div class="card-body ">
                                <h1 style="text-align: center;"><a href="/"><img
                                            class="justify-content-center align-items-center" style="max-width:300px;"
                                            src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>"> </a>
                                </h1>
                                <!--   <p>Only Individuals who have <?= $pageTitle ?>   account and authorised access to Online
                                    Banking should
                                    proceed beyond this point.</p>-->
                                <h5 style="text-align: center;"> <?php echo $translate ?></h5>
                            </div>
                        </div>
                    </div><br>

                    <div class="section mt-3">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs capsuled" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#wema" role="tab">
                                            INTERNET ID
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#access" role="tab">
                                            EMAIL ACCESS
                                        </a>
                                    </li>

                                </ul>
                                <div class="tab-content mt-1">
                                    <div class="tab-pane fade show active" id="wema" role="tabpanel">

                                        <!-- card block -->
                                        <div class="card-body">
                                            <center>
                                                <div id="google_translate_element"></div>
                                            </center><br>
                                            <form method="post" class="signin_validate row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Internet Banking ID</label>
                                                    <input type="number" minlength="8" maxlength="15"
                                                        class="form-control" placeholder="0123456789" name="acct_no" />
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control" placeholder="********"
                                                        name="acct_password" />
                                                </div>

                                                <div class="col-12">
                                                    <a href="reset-password.php">Forgot Password?</a>
                                                </div>


                                                <div class="d-grid gap-2">
                                                    <button type="submit" name="login" class="btn btn-primary"
                                                        style="background-color:#1F1B44;">
                                                        Sign in
                                                    </button>
                                                </div>
                                            </form>
                                            <p class="mt-3 mb-0">
                                                Don't have an account?
                                                <a class="text-primary" href="./opening.php">Register</a>
                                            </p>
                                        </div>
                                        <!-- * card block -->
                                    </div>
                                    <div class="tab-pane fade" id="access" role="tabpanel">


                                        <!-- card block -->
                                        <div class="card-body">
                                            <center>
                                                <div id="google_translate_element"></div>
                                            </center><br>
                                            <form method="post" class="signin_validate row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" placeholder="*****@***.***"
                                                        name="acct_email" />
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control" placeholder="********"
                                                        name="acct_password" />
                                                </div>

                                                <div class="col-12">
                                                    <a href="reset-password.php">Forgot Password?</a>
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <button type="submit" name="emaillogin" class="btn btn-primary"
                                                        style="background-color:#1F1B44;">
                                                        Sign in
                                                    </button>
                                                </div>
                                            </form>
                                            <p class="mt-3 mb-0">
                                                Don't have an account?
                                                <a class="text-primary" href="./opening.php">Register</a>
                                            </p>
                                        </div>
                                        <!-- * card block -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- <ul class="listview image-listview text inset no-line">
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
                    </ul>-->

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