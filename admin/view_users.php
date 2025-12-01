<?php
$pageName  = "Edit User";
require_once __DIR__ . '/../config.php';
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id =:id";
$data = $conn->prepare($sql);
$data->execute(['id' => $id]);

$row = $data->fetch(PDO::FETCH_ASSOC);

$userStatus = userStatus($row);

if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../assets/user/profile/";
        $n = $row['acct_no'] . $name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE users SET acct_image=:image WHERE id =:user_id";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image' => $n,
            'user_id' => $id

        ]);

        if (true) {
            $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='#fresh';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Picture updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
        } else {
            //   echo "invalid";
        }
    }
}

if (isset($_POST['upload_picture2'])) {
    if (isset($_FILES['image2'])) {
        $file2 = $_FILES['image2'];
        $name2 = $file2['name'];

        $path2 = pathinfo($name, PATHINFO_EXTENSION);

        $allowed2 = array('jpg', 'png', 'jpeg');


        $folder2 = "../assets/user/profile/";
        $n2 = $row['acct_no'] . $name2;

        $destination2 = $folder2 . $n2;
    }
    if (move_uploaded_file($file2['tmp_name'], $destination2)) {
        $sql = "UPDATE users SET acct_image2=:image2 WHERE id =:user_id";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image2' => $n2,
            'user_id' => $id

        ]);

        if (true) {
            $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='#fresh';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Picture updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
        } else {
            //    echo "invalid";
        }
    }
}


if (isset($_POST['profile_save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $acct_type = $_POST['acct_type'];
    $acct_no = $_POST['acct_no'];
    $createdAt = $_POST['createdAt'];
    $acct_email = $_POST['acct_email'];
    $acct_gender = $_POST['acct_gender'];
    $billing_code = $_POST['billing_code'];
    $transfer = $_POST['transfer'];
    $acct_currency = $_POST['acct_currency'];
    $acct_cot = $_POST['acct_cot'];
    $acct_tax = $_POST['acct_tax'];
    $acct_imf = $_POST['acct_imf'];
    $acct_phone = $_POST['acct_phone'];
    $acct_address = $_POST['acct_address'];
    $acct_dob = $_POST['acct_dob'];
    $acct_balance = $_POST['acct_balance'];
    $loan_balance = $_POST['loan_balance'];
    $limit_remain = $_POST['limit_remain'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];



    $sql = "UPDATE users SET firstname=:firstname,lastname=:lastname,acct_no=:acct_no,createdAt=:createdAt,acct_type=:acct_type,acct_email=:acct_email,acct_gender=:acct_gender,billing_code=:billing_code,transfer=:transfer,acct_currency=:acct_currency,acct_cot=:acct_cot,acct_tax=:acct_tax,acct_imf=:acct_imf,acct_phone=:acct_phone,acct_address=:acct_address,acct_dob=:acct_dob,acct_balance=:acct_balance,loan_balance=:loan_balance,limit_remain=:limit_remain,state=:state,zipcode=:zipcode  WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'acct_no' => $acct_no,
        'createdAt' => $createdAt,
        'acct_type' => $acct_type,
        'acct_email' => $acct_email,
        'acct_gender' => $acct_gender,
        'billing_code' => $billing_code,
        'transfer' => $transfer,
        'acct_currency' => $acct_currency,
        'acct_cot' => $acct_cot,
        'acct_tax' => $acct_tax,
        'acct_imf' => $acct_imf,
        'acct_phone' => $acct_phone,
        'acct_address' => $acct_address,
        'acct_dob' => $acct_dob,
        'acct_balance' => $acct_balance,
        'loan_balance' => $loan_balance,
        'limit_remain' => $limit_remain,
        'state' => $state,
        'zipcode' => $zipcode,
        'id' => $id
    ]);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./users.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Account updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //   toast_alert('error', 'Sorry something went wrong');
    }
}





if (isset($_POST['change_pin'])) {
    $current_pin = inputValidation($_POST['current_pin']);
    $new_pin = inputValidation($_POST['new_pin']);
    $confirm_pin = inputValidation($_POST['confirm_pin']);
    $verify_pin = $row['acct_pin'];

    if ($current_pin !== $verify_pin) {
        toast_alert('error', 'Invalid Old Pin');
    } else if ($new_pin !== $confirm_pin) {
        toast_alert('error', 'Confirm Pin not Matched');
    } else if ($new_pin === $verify_pin) {
        toast_alert('error', 'New Pin Matched with Old Pin');
    } else {
        $sql2 = "UPDATE users SET acct_pin=:acct_pin WHERE id =:user_id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_pin' => $new_pin,
            'user_id' => $id
        ]);
        if (true) {
            $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./users.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Pin Changed successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
        } else {
            //  toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

if (isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
    $verification = password_verify($old_password, $row['acct_password']);

    if ($verification === false) {
        toast_alert("error", "Incorrect Old Password");
    } else if ($new_password !== $confirm_password) {
        toast_alert("error", "Confirm Password not matched");
    } else if ($new_password === $old_password) {
        toast_alert('error', 'New Password Matched with Old Password');
    } else {
        $sql2 = "UPDATE users SET acct_password=:acct_password, confirm_password=:confirm_password WHERE id =:user_id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_password' => $new_password2,
            'confirm_password' => $confirm_password, // Add the confirm_password parameter here
            'user_id' => $id
        ]);

        if ($passwordUpdate) { // Check if the update was successful
            $msg1 = "
            <div class='alert alert-warning'>
            
            <script type='text/javascript'>
                 
                    function Redirect() {
                    window.location='./users.php';
                    }
                    document.write ('');
                    setTimeout('Redirect()', 3000);
                 
                    </script>
                    
            <center><img src='../assets/images/loading.gif' width='180px'  /></center>
            
            
            <center>	<strong style='color:black;'>Your Password Change Successfully, Please Wait while we redirect you...
                   </strong></center>
              </div>
            ";
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

if (isset($_POST['status_submit'])) {
    $acct_status = $_POST['acct_status'];

    $sql = "UPDATE users SET acct_status=:acct_status WHERE id =:user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_status' => $acct_status,
        'user_id' => $id
    ]);


    $full_name = $row['firstname'] . " " . $row['lastname'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $row['acct_email'];
    $acct_no = $row['acct_no'];
    $acct_status = $row['acct_status'];
    $message = $sendMail->AdminRegisterMsg($full_name, $acct_no, $acct_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Account Status" . "-" . $APP_NAME;
    //  $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./users.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Account Status Changed, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //  toast_alert('error', 'Sorry Something Went Wrong');
    }
}


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <form method="POST">
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
                                <input type="text" class="form-control" placeholder="<?= $row['firstname'] ?>"
                                    name="firstname" value="<?= $row['firstname'] ?>">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" class="form-control" value="<?= $row['lastname'] ?>"
                                    placeholder="<?= $row['lastname'] ?>" name="lastname">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Number</label>
                                <input type="text" class="form-control" value="<?= $row['acct_no'] ?>"
                                    placeholder="<?= $row['acct_no'] ?>" name="acct_no">
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Type</label>
                                <select class="form-control select2" name="acct_type" style="width: 100%;">
                                    <option value="">Select Account Type</option>
                                    <option value="Savings"
                                        <?php echo ($row['acct_type'] === 'Savings') ? 'selected' : ''; ?>>Savings
                                        Account</option>
                                    <option value="Current"
                                        <?php echo ($row['acct_type'] === 'Current') ? 'selected' : ''; ?>>Current
                                        Account</option>
                                    <option value="Checking"
                                        <?php echo ($row['acct_type'] === 'Checking') ? 'selected' : ''; ?>>Checking
                                        Account</option>
                                    <option value="Fixed Deposit"
                                        <?php echo ($row['acct_type'] === 'Fixed Deposit') ? 'selected' : ''; ?>>Fixed
                                        Deposit</option>
                                    <option value="Platinum"
                                        <?php echo ($row['acct_type'] === 'Platinum') ? 'selected' : ''; ?>>Platinum
                                    </option>
                                    <option value="Non Resident"
                                        <?php echo ($row['acct_type'] === 'Non Resident') ? 'selected' : ''; ?>>Non
                                        Resident Account</option>
                                    <option value="Online Banking"
                                        <?php echo ($row['acct_type'] === 'Online Banking') ? 'selected' : ''; ?>>Online
                                        Banking</option>
                                    <option value="Domiciliary Account"
                                        <?php echo ($row['acct_type'] === 'Domiciliary Account') ? 'selected' : ''; ?>>
                                        Domiciliary Account</option>
                                    <option value="Joint Account"
                                        <?php echo ($row['acct_type'] === 'Joint Account') ? 'selected' : ''; ?>>Joint
                                        Account</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" value="<?= $row['acct_email'] ?>"
                                    placeholder="<?= $row['acct_email'] ?>" name="acct_email">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-control select2" name="acct_gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male"
                                        <?php echo ($row['acct_gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female"
                                        <?php echo ($row['acct_gender'] === 'Female') ? 'selected' : ''; ?>>Female
                                    </option>
                                    <option value="Other"
                                        <?php echo ($row['acct_gender'] === 'Other') ? 'selected' : ''; ?>>Other
                                    </option>
                                </select>
                            </div>


                            <!--                   <div class="form-group">
    <label>Billing Code Option</label>
    <select class="form-control select2" name="billing_code" style="width: 100%;">
        <option value="">Select Option</option>
        <option value="1" <?php echo ($row['billing_code'] === '1') ? 'selected' : ''; ?>>On</option>
        <option value="0" <?php echo ($row['billing_code'] === '0') ? 'selected' : ''; ?>>Off</option>
    </select>
</div>-->

                            <div class="form-group">
                                <label>Billing Code Option</label>
                                <select class="form-control select2" name="billing_code" style="width: 100%;">
                                    <option value="">Select Option</option>
                                    <option value="1" <?php echo ($row['billing_code'] == '1') ? 'selected' : ''; ?>>3
                                        Codes and OTP</option>
                                    <option value="2" <?php echo ($row['billing_code'] == '2') ? 'selected' : ''; ?>>3
                                        Codes and Account Pin</option>
                                    <option value="3" <?php echo ($row['billing_code'] == '3') ? 'selected' : ''; ?>>
                                        Account Pin Only</option>
                                    <option value="0" <?php echo ($row['billing_code'] == '0') ? 'selected' : ''; ?>>
                                        OTP Code only</option>
                                </select>
                            </div>


                            <!--
<div class="form-group">
    <label>Transfer Code Option</label>
    <select class="form-control select2" name="transfer" style="width: 100%;">
        <option value="">Select Option</option>
        <option value="1" <?php echo ($row['transfer'] === '1') ? 'selected' : ''; ?>>On</option>
        <option value="0" <?php echo ($row['transfer'] === '0') ? 'selected' : ''; ?>>Off</option>
    </select>
</div>
-->
                            <input type="hidden" name="transfer" value="1">

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?= $page['code1'] ?> Code</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="4"
                                    autocomplete="off" value="<?= $row['acct_cot'] ?>" class="form-control"
                                    name="acct_cot" placeholder="<?= $row['acct_cot'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?= $page['code2'] ?> Code</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="4"
                                    autocomplete="off" value="<?= $row['acct_tax'] ?>" class="form-control"
                                    name="acct_tax" placeholder="<?= $row['acct_tax'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?= $page['code3'] ?> Code</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="4"
                                    autocomplete="off" value="<?= $row['acct_imf'] ?>" class="form-control"
                                    name="acct_imf" placeholder="<?= $row['acct_imf'] ?>">
                            </div>


                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Phone</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="12"
                                    autocomplete="off" value="<?= $row['acct_phone'] ?>" class="form-control"
                                    name="acct_phone" placeholder="<?= $row['acct_phone'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Address</label>
                                <input type="text" value="<?= $row['acct_address'] ?>" class="form-control"
                                    name="acct_address" placeholder="<?= $row['acct_address'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Date of Birth</label>
                                <input type="date" class="form-control" value="<?= $row['acct_dob'] ?>" name="acct_dob"
                                    placeholder="<?= $row['acct_dob'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Balance</label>
                                <input type="number" class="form-control" value="<?= $row['acct_balance'] ?>"
                                    name="acct_balance" placeholder="<?= $row['acct_balance'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Currency</label>
                                <select class="form-control select2" required name="acct_currency">
                                    <option value="">Select Account Currency</option>

                                    <option value="$" <?php echo ($row['acct_currency'] === '$') ? 'selected' : ''; ?>>
                                        United States Dollar (USD) $</option>
                                    <option value="C$"
                                        <?php echo ($row['acct_currency'] === 'C$') ? 'selected' : ''; ?>>Canadian
                                        Dollar (CAD) C$</option>
                                    <option value="R$"
                                        <?php echo ($row['acct_currency'] === 'R$') ? 'selected' : ''; ?>>Brazilian Real
                                        (BRL) R$</option>
                                    <option value="Mex$"
                                        <?php echo ($row['acct_currency'] === 'Mex$') ? 'selected' : ''; ?>>Mexican Peso
                                        (MXN) Mex$</option>

                                    <option value="€" <?php echo ($row['acct_currency'] === '€') ? 'selected' : ''; ?>>
                                        Euro (EUR) €</option>
                                    <option value="£" <?php echo ($row['acct_currency'] === '£') ? 'selected' : ''; ?>>
                                        British Pound Sterling (GBP) £</option>
                                    <option value="Fr"
                                        <?php echo ($row['acct_currency'] === 'Fr') ? 'selected' : ''; ?>>Swiss Franc
                                        (CHF) Fr</option>
                                    <option value="kr"
                                        <?php echo ($row['acct_currency'] === 'kr') ? 'selected' : ''; ?>>Swedish Krona
                                        (SEK) kr</option>
                                    <option value="kr"
                                        <?php echo ($row['acct_currency'] === 'kr') ? 'selected' : ''; ?>>Norwegian
                                        Krone (NOK) kr</option>
                                    <option value="₽" <?php echo ($row['acct_currency'] === '₽') ? 'selected' : ''; ?>>
                                        Russian Ruble (RUB) ₽</option>

                                    <option value="¥" <?php echo ($row['acct_currency'] === '¥') ? 'selected' : ''; ?>>
                                        Japanese Yen (JPY) ¥</option>
                                    <option value="¥" <?php echo ($row['acct_currency'] === '¥') ? 'selected' : ''; ?>>
                                        Chinese Yuan (CNY) ¥</option>
                                    <option value="₹" <?php echo ($row['acct_currency'] === '₹') ? 'selected' : ''; ?>>
                                        Indian Rupee (INR) ₹</option>
                                    <option value="HK$"
                                        <?php echo ($row['acct_currency'] === 'HK$') ? 'selected' : ''; ?>>Hong Kong
                                        Dollar (HKD) HK$</option>
                                    <option value="S$"
                                        <?php echo ($row['acct_currency'] === 'S$') ? 'selected' : ''; ?>>Singapore
                                        Dollar (SGD) S$</option>
                                    <option value="₩" <?php echo ($row['acct_currency'] === '₩') ? 'selected' : ''; ?>>
                                        South Korean Won (KRW) ₩</option>

                                    <option value="A$"
                                        <?php echo ($row['acct_currency'] === 'A$') ? 'selected' : ''; ?>>Australian
                                        Dollar (AUD) A$</option>
                                    <option value="NZ$"
                                        <?php echo ($row['acct_currency'] === 'NZ$') ? 'selected' : ''; ?>>New Zealand
                                        Dollar (NZD) NZ$</option>
                                    <option value="R" <?php echo ($row['acct_currency'] === 'R') ? 'selected' : ''; ?>>
                                        South African Rand (ZAR) R</option>
                                    <option value="₺" <?php echo ($row['acct_currency'] === '₺') ? 'selected' : ''; ?>>
                                        Turkish Lira (TRY) ₺</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loan</label>
                                <input type="number" value="<?= $row['loan_balance'] ?>" class="form-control"
                                    name="loan_balance" placeholder="<?= $row['loan_balance'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Limit Remain</label>
                                <input type="number" value="<?= $row['limit_remain'] ?>" class="form-control"
                                    name="limit_remain" placeholder="<?= $row['limit_remain'] ?>">
                            </div>

                            <div class="form-group">
                                <label>State</label>
                                <input type="text" value="<?= $row['state'] ?>" class="form-control" name="state"
                                    placeholder="<?= $row['state'] ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Zipcode</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="5"
                                    autocomplete="off" class="form-control" value="<?= $row['zipcode'] ?>"
                                    placeholder="<?= $row['zipcode'] ?>" name="zipcode">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date of Account Creation</label>
                                <input type="text" class="form-control" value="<?= $row['createdAt'] ?>"
                                    name="createdAt" placeholder="<?= $row['createdAt'] ?>">
                            </div>


                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="profile_save" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </form>
        <!-- /.box -->

        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Current Password: <?= $row['confirm_password'] ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Current Password</label>
                                <input type="password" class="form-control" name="old_password"
                                    placeholder="<?= $row['confirm_password'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">New Password</label>
                                <input type="password" class="form-control" name="new_password"
                                    placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password"
                                    placeholder="Old Password">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="change_password" class="btn btn-primary">Change
                                Password</button>
                        </div>
                    </form>
                </div>
                <div>
                    Profile Image
                </div>
                <form method="POST" id="general-info" enctype="multipart/form-data"
                    style="display: flex; align-items: center;">
                    <!-- Display the current image using an <img> tag -->

                    <?php
                    // Fetch the image name from the database
                    $user_image = $row['acct_image']; // Assuming $row contains the user data from the database

                    // Define the path to the images directory
                    $image_folder = "../assets/user/profile/";

                    // Set the default image
                    $default_image = "default.png";

                    // Check if the image exists and is not empty
                    if (!empty($user_image) && file_exists($image_folder . $user_image)) {
                        $image_to_display = $image_folder . $user_image;
                    } else {
                        $image_to_display = $image_folder . $default_image;
                    }
                    ?>

                    <!-- Display the image in HTML -->
                    <img src="<?= $image_to_display ?>" alt="Profile Image" id="image-preview" style="height: 120px;">




                    <div class="form-group" style="flex: 1;">
                        <input type="file" id="input-file-max-fs" class="form-control" name="image"
                            data-max-file-size="2M" />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="upload_picture" class="btn btn-primary">Change Profile Pic</button>
                    </div>
                </form>

                <br><br>

                <div id="fresh">
                    ID Card
                </div>
                <form method="POST" id="general-info" enctype="multipart/form-data"
                    style="display: flex; align-items: center;">
                    <!-- Display the current ID card image using an <img> tag -->
                    <?php
                    // Fetch the image name from the database
                    $user_image2 = $row['acct_image2']; // Assuming $row contains the user data from the database

                    // Define the path to the images directory
                    $image_folder = "../assets/user/profile/";

                    // Set the default image
                    $default_image2 = "id.jpg";

                    // Check if the image exists and is not empty
                    if (!empty($user_image2) && file_exists($image_folder . $user_image2)) {
                        $image_to_display2 = $image_folder . $user_image2;
                    } else {
                        $image_to_display2 = $image_folder . $default_image2;
                    }
                    ?>

                    <!-- Display the image in HTML -->
                    <img src="<?= $image_to_display2 ?>" alt="ID Card" id="id-card-preview" style="height: 120px;">



                    <div class="form-group" style="flex: 1;">
                        <input type="file" id="input-file-max-fs2" class="form-control" name="image2"
                            data-max-file-size="2M" />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="upload_picture2" class="btn btn-primary">Change ID Card</button>
                    </div>
                </form>

                <script>
                    // Function to display the selected image in the image preview
                    function displayImage(event) {
                        var input = event.target;
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('image-preview').src = e.target.result;
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    // Function to display the selected ID card image in the preview
                    function displayIDCard(event) {
                        var input = event.target;
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('id-card-preview').src = e.target.result;
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    // Add event listeners to the file inputs
                    document.getElementById('input-file-max-fs').addEventListener('change', displayImage);
                    document.getElementById('input-file-max-fs2').addEventListener('change', displayIDCard);
                </script>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Current Pin : <?= $row['acct_pin'] ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" autocomplete="off" autofocus="off">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Old Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="4"
                                    autocomplete="off" class="form-control" name="current_pin"
                                    placeholder="<?= $row['acct_pin'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">New Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="4"
                                    autocomplete="off" class="form-control" name="new_pin" placeholder="New Pin">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Confirm New Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="4"
                                    autocomplete="off" class="form-control" name="confirm_pin"
                                    placeholder="Confirm Pin">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="change_pin" class="btn btn-primary">Change Pin</button>
                        </div>
                    </form>
                </div>

                <div>
                    CURRENT STATUS: <b><?= $userStatus ?></b>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <select class="form-control select2" name="acct_status" style="width: 100%;">
                            <option>Select Account Status</option>
                            <option value="active">ACTIVE</option>
                            <option value="suspend">PAUSE TRANSFER</option>
                            <option value="hold">DISABLE LOGIN</option>

                        </select>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="status_submit" class="btn btn-primary">Change Status</button>
                    </div>
                </form>
                <br><br>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>