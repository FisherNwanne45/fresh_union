<?php
$pageName  = "Open an Account";
include ROOT_PATH . "/auth/reg.php";

if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
    exit;
}

if (isset($_POST['regSubmit'])) {
    $recaptchaSecret = '6Lf0jN8pAAAAALs-FGCApICznN5E5bJlHGk7ohsd'; // Replace with your secret key
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($response);

    if (!$responseData->success) {
        toast_alert('error', 'reCAPTCHA verification failed. Please try again.');
    } else {
        $acct_no = "1202" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $acct_status = "hold";
        $acct_address = $_POST['address'];
        $acct_type = $_POST['acct_type'];
        $acct_gender = $_POST['acct_gender'];
        $state = $_POST['state'];
        $zipcode = $_POST['zipcode'];
        $acct_email = $_POST['acct_email'];
        $acct_phone = $_POST['phoneNumber'];
        $acct_password = $_POST['acct_password'];
        $confirmPassword = $_POST['confirmPassword'];
        $acct_pin = inputValidation($_POST['acct_pin']);
        $acct_dob = $_POST['acct_dob'];

        if ($acct_password !== $confirmPassword) {
            toast_alert('error', 'Password not matched');
        } else {
            // Checking existing email
            $usersVerified = "SELECT * FROM users WHERE acct_email=:acct_email OR acct_phone=:acct_phone";
            $stmt = $conn->prepare($usersVerified);
            $stmt->execute([
                'acct_email' => $acct_email,
                'acct_phone' => $acct_phone
            ]);

            if ($stmt->rowCount() > 0) {
                toast_alert('error', 'Email or Phone Number Already Exists');
            } else {
                if (isset($_FILES['image'])) {
                    $file = $_FILES['image'];
                    $name = $file['name'];
                    $path = pathinfo($name, PATHINFO_EXTENSION);
                    $allowed = ['jpg', 'png', 'jpeg'];
                    $folder = "./assets/user/profile/";
                    $n = $acct_no . $name;
                    $destination = $folder . $n;
                    move_uploaded_file($file['tmp_name'], $destination);
                }

                // INSERT INTO DATABASE
                $registered = "INSERT INTO users (firstname, lastname, acct_email, acct_password, acct_no, acct_status, acct_phone, acct_type, acct_gender, state, acct_address, zipcode, acct_dob, acct_pin, acct_image) 
                                VALUES (:firstname, :lastname, :acct_email, :acct_password, :acct_no, :acct_status, :acct_phone, :acct_type, :acct_gender, :state, :acct_address, :zipcode, :acct_dob, :acct_pin, :acct_image)";
                $reg = $conn->prepare($registered);
                $reg->execute([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'acct_email' => $acct_email,
                    'acct_password' => password_hash((string)$acct_password, PASSWORD_BCRYPT),
                    'acct_no' => $acct_no,
                    'acct_status' => $acct_status,
                    'acct_phone' => $acct_phone,
                    'acct_type' => $acct_type,
                    'acct_gender' => $acct_gender,
                    'state' => $state,
                    'acct_address' => $acct_address,
                    'zipcode' => $zipcode,
                    'acct_dob' => $acct_dob,
                    'acct_pin' => $acct_pin,
                    'acct_image' => $n
                ]);

                $number = $acct_phone;
                $full_name = $firstname . " " . $lastname;
                $APP_NAME = WEB_TITLE;

                if ($page['twillio_status'] == '1') {
                    $messageText = "Dear " . $full_name . ", Thank you for registering at " . $APP_NAME . ". Kindly wait while your account is activated, Thanks ";
                    $sendSms->sendSmsCode($number, $messageText);
                }

                if (true) {
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['url_address'];
                    $message = $sendMail->RegisterMsg($full_name, $acct_no, $acct_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                    $subject = "Welcome to " . $APP_NAME;
                    $email_message->send_mail($acct_email, $message, $subject);

                    $msg1 = "
                    <div class='alert alert-warning'>
                        <script type='text/javascript'>
                            function Redirect() {
                                window.location='./login.php';
                            }
                            setTimeout('Redirect()', 6000);
                        </script>
                        <center><img src='../assets/images/loading.gif' width='180px' /></center>
                        <center><strong style='color:black;'>Sending Account Registration Request...</strong></center>
                    </div>";
                } else {
                    toast_alert("error", "Invalid details");
                }
            }
        }
    }
}
?>

<!-- App Header -->
<div class="appHeader no-border transparent position-absolute">
    <div class="left"></div>
    <div class="pageTitle"></div>
    <div class="right"></div>
</div>
<!-- * App Header -->

<div id="appCapsule">
    <div class="authincation section-padding">
        <div class="container">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-8">
                    <div class="auth-form card">
                        <div class="card-body">
                            <h1 style="text-align: center;"><a href="/"><img
                                        class="justify-content-center align-items-center" style="max-width:300px;"
                                        src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>"> </a> </h1>
                            <h2 style="text-align: center;">Online Account Opening<br> </h2>
                            <h5 style="text-align: center;">
                                <div id="google_translate_element"></div>
                                <script type="text/javascript">
                                    function googleTranslateElementInit() {
                                        new google.translate.TranslateElement({
                                            pageLanguage: 'en',
                                            includedLanguages: 'ar,en,es,jv,ko,pa,pt,ru,zh-CN,zh-TW,ja',
                                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                                        }, 'google_translate_element');
                                    }
                                </script>
                                <script type="text/javascript"
                                    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
                                </script>
                            </h5>
                        </div>
                    </div><br>
                    <div class="auth-form card">
                        <div class="card-body">
                            <?php if (isset($msg1)) echo $msg1; ?>

                            <form method="post" class="signin_validate row g-3" enctype="multipart/form-data">
                                <h4 class="text-success" id="register-error"></h4>
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" required placeholder="First Name"
                                        name="firstname">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" required placeholder="Last Name"
                                        name="lastname">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" required placeholder="hello@example.com"
                                        name="acct_email">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+</span>
                                        </div>
                                        <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="9"
                                            maxlength="12" autocomplete="off" placeholder="1 440 941 4254"
                                            class="form-control wizard-required" name="phoneNumber">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Home Address</label>
                                    <input type="text" class="form-control" required placeholder="Home Address"
                                        name="address">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" required placeholder="State" name="state">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control wizard-required" placeholder="City" id="city"
                                        name="city">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Zipcode/postal code</label>
                                    <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="4"
                                        maxlength="6" autocomplete="off" class="form-control wizard-required"
                                        placeholder="100001" id="zipcode" name="zipcode">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select name="acct_gender" required class="form-control" data-width='100%'>
                                        <option value="">Select Gender Type</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Account Type</label>
                                    <select name="acct_type" required class="form-control" data-width='100%'>
                                        <option value="">Select Account Type</option>
                                        <option value="Savings">Savings Account</option>
                                        <option value="Current">Current Account</option>
                                        <option value="Checking">Checking Account</option>
                                        <option value="Fixed Deposit">Fixed Deposit</option>
                                        <option value="Non Resident">Non Resident Account</option>
                                        <option value="Joint Account">Joint Account</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Upload Picture</label>
                                    <input type="file" id="input-file-max-fs" required class="form-control" name="image"
                                        data-max-file-size="2M" />
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" required placeholder="Date of Birth"
                                        name="acct_dob">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">4 Digit Pin</label>
                                    <input type="text" class="form-control" inputmode="numeric" required
                                        pattern="[0-9]+" maxlength="4" autocomplete="off" style="margin-bottom: 5px"
                                        placeholder="****" name="acct_pin">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" maxlength="20" required
                                        placeholder="Password" name="acct_password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" maxlength="20" required
                                        placeholder="Confirm Password" name="confirmPassword">
                                </div>

                                <div class="col-md-12">
                                    <div class="g-recaptcha" data-sitekey="6Lf0jN8pAAAAAEdvb8r6VeA88wIcaSrUkXsA1wq2">
                                    </div> <!-- Replace with your site key -->
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" name="regSubmit">Create new
                                        account</button>
                                </div>
                            </form>
                            <div class="text-center">
                                <p class="mt-3 mb-0"> <a class="text-primary" href="./login.php">Sign in</a> to your
                                    account</p>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include ROOT_PATH . "/auth/footer.php";
?>

<!-- Add this script at the end of the body tag -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>