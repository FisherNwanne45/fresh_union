<?php
require_once __DIR__ . '/../config.php';
$pageName = "Create Profile";
include(ROOT_PATH . "/admin/layout/header.php");

if (isset($_POST['register'])) {
    $acct_no = $_POST['acct_no'];
    $acct_currency = $_POST['acct_currency'];
    $acct_type = $_POST['acct_type'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $acct_status = "active";
    $acct_gender = $_POST['acct_gender'];
    $acct_address = $_POST['acct_address'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $acct_email = $_POST['acct_email'];
    $acct_phone = $_POST['acct_phone'];
    $acct_password = inputValidation($_POST['acct_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);
    $acct_dob = $_POST['acct_dob'];
    $acct_balance = $_POST['acct_balance'];
    $acct_pin = inputValidation($_POST['acct_pin']);

    if ($acct_password !== $confirm_password) {
        toast_alert('error', 'Password not matched');
    } else {
        // Check if email or phone number already exists
        $usersVerified = "SELECT * FROM users WHERE acct_email=:acct_email OR acct_phone=:acct_phone";
        $stmt = $conn->prepare($usersVerified);
        $stmt->execute([
            'acct_email' => $acct_email,
            'acct_phone' => $acct_phone
        ]);

        if ($stmt->rowCount() > 0) {
            toast_alert('error', 'Email or Phone Number Already Exists');
        } else {
            $n = $n2 = "";
            $uploadSuccess = true;

            // Handle image upload
            if (isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $name = $file['name'];
                $path = pathinfo($name, PATHINFO_EXTENSION);
                $allowed = ['jpg', 'png', 'jpeg'];
                $folder = "../assets/user/profile/";
                $n = $acct_no . "." . $path;
                $destination = $folder . $n;

                if (in_array($path, $allowed)) {
                    if (!move_uploaded_file($file['tmp_name'], $destination)) {
                        error_log('Failed to upload image: ' . $file['tmp_name'] . ' to ' . $destination);
                        toast_alert('error', 'Failed to upload image');
                        $uploadSuccess = false;
                    }
                } else {
                    toast_alert('error', 'Invalid file type for image');
                    $uploadSuccess = false;
                }
            }

            // Handle image2 upload
            if (isset($_FILES['image2'])) {
                $file2 = $_FILES['image2'];
                $name2 = $file2['name'];
                $path2 = pathinfo($name2, PATHINFO_EXTENSION);
                $allowed2 = ['jpg', 'png', 'jpeg'];
                $folder2 = "../assets/user/profile/";
                $n2 = $acct_no . "_2." . $path2;
                $destination2 = $folder2 . $n2;

                if (in_array($path2, $allowed2)) {
                    if (!move_uploaded_file($file2['tmp_name'], $destination2)) {
                        error_log('Failed to upload image2: ' . $file2['tmp_name'] . ' to ' . $destination2);
                        toast_alert('error', 'Failed to upload image2');
                        $uploadSuccess = false;
                    }
                } else {
                    toast_alert('error', 'Invalid file type for image2');
                    $uploadSuccess = false;
                }
            }

            if ($uploadSuccess) {
                // Insert into the database
                $registered = "INSERT INTO users (firstname, lastname, acct_email, acct_password, confirm_password, acct_no, acct_currency, acct_status, acct_phone, acct_type, acct_gender, state, acct_address, zipcode, acct_dob, acct_balance, acct_pin, acct_image, acct_image2) 
                               VALUES (:firstname, :lastname, :acct_email, :acct_password, :confirm_password, :acct_no, :acct_currency, :acct_status, :acct_phone, :acct_type, :acct_gender, :state, :acct_address, :zipcode, :acct_dob, :acct_balance, :acct_pin, :image, :image2)";
                $reg = $conn->prepare($registered);
                if (!$reg->execute([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'acct_email' => $acct_email,
                    'acct_password' => password_hash($acct_password, PASSWORD_BCRYPT),
                    'confirm_password' => $confirm_password,
                    'acct_no' => $acct_no,
                    'acct_currency' => $acct_currency,
                    'acct_status' => $acct_status,
                    'acct_phone' => $acct_phone,
                    'acct_type' => $acct_type,
                    'acct_gender' => $acct_gender,
                    'state' => $state,
                    'acct_address' => $acct_address,
                    'zipcode' => $zipcode,
                    'acct_dob' => $acct_dob,
                    'acct_balance' => $acct_balance,
                    'acct_pin' => $acct_pin,
                    'image' => $n,
                    'image2' => $n2
                ])) {
                    error_log('Database error: ' . print_r($reg->errorInfo(), true));
                    toast_alert('error', 'Failed to register user. Please try again.');
                } else {
                    // Success
                    $full_name = $firstname . " " . $lastname;
                    $APP_NAME = WEB_TITLE;
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['url_address'];
                    $message = $sendMail->AdminRegisterMsg($full_name, $acct_no, $acct_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);

                    // Send the email
                    $subject = "Welcome to " . $APP_NAME;
                    $email_message->send_mail($acct_email, $message, $subject);

                    echo "
                    <div class='alert alert-warning'>
                        <script type='text/javascript'>
                            function Redirect() {
                                window.location='./users.php';
                            }
                            setTimeout('Redirect()', 3000);
                        </script>
                        <center><img src='../assets/images/loading.gif' width='180px' /></center>
                        <center><strong style='color:black;'>Registered, Welcome Email Sent...</strong></center>
                        <center><strong style='color:black;'>Please Wait while we redirect to login...</strong></center>
                    </div>";
                }
            }
        }
    }
}

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create New User
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <form method="POST" enctype="multipart/form-data">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" name="firstname" required class="form-control"
                                    placeholder="First Name">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" name="lastname" required class="form-control"
                                    placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Number</label>
                                <input type="number" name="acct_no" required class="form-control"
                                    placeholder="Account Number">
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Type</label>
                                <select class="form-control select2" name="acct_type" required style="width: 100%;">
                                    <option>Select Account Type</option>
                                    <option value="Savings">Savings Account</option>
                                    <option value="Current">Current Account</option>
                                    <option value="Checking">Checking Account</option>
                                    <option value="Platinum">Platinum Account</option>
                                    <option value="Fixed Deposit">Fixed Deposit</option>
                                    <option value="Non Resident">Non Resident Account</option>
                                    <option value="Online Banking">Online Banking</option>
                                    <option value="Domicilary Account">Domicilary Account</option>
                                    <option value="Joint Account">Joint Account</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Account Currency</label>
                                <select class="form-control select2" required name="acct_currency">
                                    <option value="">Select Account Currency</option>

                                    <option value="$">United States Dollar (USD) $</option>
                                    <option value="$">Canadian Dollar (CAD) C$</option>
                                    <option value="R$">Brazilian Real (BRL) R$</option>
                                    <option value="$">Mexican Peso (MXN) Mex$</option>

                                    <option value="€">Euro (EUR) €</option>
                                    <option value="£">British Pound Sterling (GBP) £</option>
                                    <option value="Fr">Swiss Franc (CHF) Fr</option>
                                    <option value="kr">Swedish Krona (SEK) kr</option>
                                    <option value="kr">Norwegian Krone (NOK) kr</option>
                                    <option value="₽">Russian Ruble (RUB) ₽</option>

                                    <option value="¥">Japanese Yen (JPY) ¥</option>
                                    <option value="¥">Chinese Yuan (CNY) ¥</option>
                                    <option value="₹">Indian Rupee (INR) ₹</option>
                                    <option value="$">Hong Kong Dollar (HKD) HK$</option>
                                    <option value="$">Singapore Dollar (SGD) S$</option>
                                    <option value="₩">South Korean Won (KRW) ₩</option>

                                    <option value="$">Australian Dollar (AUD) A$</option>
                                    <option value="$">New Zealand Dollar (NZD) NZ$</option>
                                    <option value="R">South African Rand (ZAR) R</option>
                                    <option value="₺">Turkish Lira (TRY) ₺</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" required placeholder="Enter Email"
                                    name="acct_email">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-control select2" required name="acct_gender">
                                    <option>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Zipcode</label>
                                <input type="text" required name="zipcode" inputmode="numeric" required pattern="[0-9]+"
                                    minlength="3" maxlength="5" autocomplete="off" class="form-control"
                                    placeholder="23456">
                            </div>


                            <div class="row">

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="acct_cot">4 Digit <?= $page['code1'] ?></label>
                                        <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="3"
                                            maxlength="4" autocomplete="off" class="form-control" name="acct_cot"
                                            placeholder="Enter 4 Digit <?= $page['code1'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="acct_tax">4 Digit <?= $page['code2'] ?></label>
                                        <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="3"
                                            maxlength="4" autocomplete="off" class="form-control" name="acct_tax"
                                            placeholder="Enter 4 Digit <?= $page['code2'] ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label>Upload Profile Picture <small><i>(Optional)</i></small></label>
                                <input type="file" id="input-file-max-fs" class="form-control" name="image"
                                    data-max-file-size="2M" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            </div>

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone Number</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="9"
                                    maxlength="12" autocomplete="off" required class="form-control" name="acct_phone"
                                    placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <input name="acct_address" required type="text" class="form-control"
                                    placeholder="Address">
                                <input value="50000000" name="limit_remain" type="text" hidden>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date of Birth</label>
                                <input type="date" required class="form-control" name="acct_dob"
                                    placeholder="Date of birth">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Balance</label>
                                <input type="number" required inputmode="numeric" required pattern="[0-9]+"
                                    maxlength="15" autocomplete="off" name="acct_balance" class="form-control"
                                    placeholder="Account Balance">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loan Balance</label>
                                <input inputmode="numeric" required pattern="[0-9]+" maxlength="15" autocomplete="off"
                                    type="number" required name="loan_balance" class="form-control"
                                    placeholder="Loan Balance">
                            </div>

                            <div class="form-group">
                                <label>State</label>
                                <input type="text" required class="form-control" name="state" placeholder="Enter State">
                            </div>




                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" required class="form-control" name="acct_password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="password" required class="form-control" name="confirm_password"
                                    placeholder="Confirm Password">
                            </div>
                            <div class="row">

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="acct_imf">4 Digit <?= $page['code3'] ?></label>
                                        <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="3"
                                            maxlength="4" autocomplete="off" class="form-control" name="acct_imf"
                                            placeholder="Enter 4 Digit <?= $page['code3'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">4 Digit Transaction Pin</label>
                                        <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="3"
                                            maxlength="4" autocomplete="off" required class="form-control"
                                            name="acct_pin" placeholder="Enter Pin">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Upload ID Card <small><i> (Optional)</i></small></label>
                                <input type="file" id="input-file-max-fs" class="form-control" name="image2"
                                    data-max-file-size="2M" />

                            </div>

                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="register" class="btn btn-primary">Create New Profile</button>
                </div>
            </div>
        </form>
        <!-- /.box -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>