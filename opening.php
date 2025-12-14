<?php
require_once __DIR__ . '/config.php';
$pageName  = "Open an Account";
include ROOT_PATH . "/auth/reg.php";

if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
    exit;
}

if (isset($_POST['regSubmit'])) {
    $recaptchaSecret = $page['secretkey']; // Replace with your secret key
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
                    // toast_alert("error", msg: "Invalid details");
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $pageName  ?> - <?= $pageTitle ?> </title>
    <meta name="description" content="<?= $pageTitle ?> Mobile Banking">
    <link rel="shortcut icon" href="<?= $web_url ?>/admin/assets/images/logo/<?= $page['favicon'] ?>"
        type="image/x-icon" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1F1B44;
            --secondary-color: #4A44A6;
            --accent-color: #6C63FF;
            --light-color: #F8F9FA;
            --dark-color: #212529;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .register-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }

        .register-left {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-right {
            padding: 40px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .brand-logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }

        .feature-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .feature-list i {
            margin-right: 10px;
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
        }

        .btn-register {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .security-badge {
            background-color: var(--light-color);
            color: var(--primary-color);
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
        }

        .security-badge i {
            color: var(--success-color);
            margin-right: 5px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }

        .login-link {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .section-title {
            color: var(--primary-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .progress {
            height: 8px;
            margin-bottom: 30px;
        }

        .progress-bar {
            background-color: var(--accent-color);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-btn {
            background-color: var(--light-color);
            border: 1px dashed #ccc;
            color: var(--dark-color);
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload-btn:hover {
            background-color: #e9ecef;
            border-color: var(--accent-color);
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        @media (max-width: 768px) {
            .register-left {
                padding: 30px;
            }

            .register-right {
                padding: 30px;
            }
        }
    </style>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript"
        src="translate.google.com/translate_a/fa0d8a0d8.txt?cb=googleTranslateElementInit"></script>
</head>

<body>
    <div class="container">
        <div class="register-container">
            <div class="row g-0">
                <!-- Left Side - Branding & Features -->
                <div class="col-lg-5 register-left">
                    <div class="text-center mb-4">
                        <a href="<?= $web_url ?>"> <img
                                src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>"
                                alt="Wallet Logo" class="brand-logo"></a>
                        <?php echo $translate ?>
                    </div>
                    <h2 class="mb-3">Join Our Secure Wallet</h2>
                    <p class="mb-4">Open your account in minutes and enjoy our premium banking features with
                        top-tier security.</p>

                    <ul class="feature-list">
                        <li><i class="fas fa-shield-alt"></i> Advanced security & encryption</li>
                        <li><i class="fas fa-piggy-bank"></i> Multiple account types</li>
                        <li><i class="fas fa-bolt"></i> Instant account setup</li>
                        <li><i class="fas fa-mobile-alt"></i> Mobile banking access</li>
                        <li><i class="fas fa-headset"></i> 24/7 customer support</li>
                    </ul>

                    <div class="security-badge">
                        <i class="fas fa-lock"></i> Your information is securely encrypted
                    </div>
                </div>

                <!-- Right Side - Registration Form -->
                <div class="col-lg-7 register-right">
                    <h3 class="mb-4">Open Your Account</h3>
                    <p class="text-muted mb-4">Fill in your details to create your wallet account</p>

                    <!-- Progress Bar -->
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <?php if (isset($msg1)) echo $msg1; ?>

                    <form method="post" class="signin_validate" enctype="multipart/form-data" id="registrationForm">
                        <!-- Personal Information Section -->
                        <div class="form-section active" id="section1">
                            <h5 class="section-title">Personal Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            placeholder="Enter your first name" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            placeholder="Enter your last name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="acct_email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="acct_email" name="acct_email"
                                            placeholder="hello@example.com" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" inputmode="numeric" required pattern="[0-9]+"
                                            minlength="9" maxlength="12" autocomplete="off"
                                            placeholder="14409414254" class="form-control" name="phoneNumber">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="acct_dob" class="form-label">Date of Birth</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" id="acct_dob" name="acct_dob"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="acct_gender" class="form-label">Gender</label>
                                    <select name="acct_gender" required class="form-control" data-width='100%'>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="nav-buttons">
                                <div></div> <!-- Empty div for spacing -->
                                <button type="button" class="btn btn-register next-section" data-next="2">Next <i
                                        class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <!-- Address Information Section -->
                        <div class="form-section" id="section2">
                            <h5 class="section-title">Address Information</h5>

                            <div class="mb-3">
                                <label for="address" class="form-label">Home Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter your home address" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="state" name="state"
                                            placeholder="Enter your state" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        <input type="text" class="form-control" id="city" name="city"
                                            placeholder="Enter your city">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="zipcode" class="form-label">Zipcode/Postal Code</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                    <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="4"
                                        maxlength="6" autocomplete="off" class="form-control" id="zipcode"
                                        name="zipcode" placeholder="100001">
                                </div>
                            </div>

                            <div class="nav-buttons">
                                <button type="button" class="btn btn-outline-secondary prev-section"
                                    data-prev="1"><i class="fas fa-arrow-left me-2"></i> Back</button>
                                <button type="button" class="btn btn-register next-section" data-next="3">Next <i
                                        class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <!-- Account Information Section -->
                        <div class="form-section" id="section3">
                            <h5 class="section-title">Account Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="acct_type" class="form-label">Account Type</label>
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

                                <div class="col-md-6 mb-3">
                                    <label for="acct_pin" class="form-label">4 Digit PIN</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="text" class="form-control" inputmode="numeric" required
                                            pattern="[0-9]+" maxlength="4" autocomplete="off" placeholder="****"
                                            name="acct_pin">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Profile Picture</label>
                                <div class="file-upload">
                                    <button type="button" class="file-upload-btn">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>Choose File (Max: 2MB)
                                    </button>
                                    <input type="file" id="input-file-max-fs" required class="file-upload-input"
                                        name="image" data-max-file-size="2M" />
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                </div>
                                <div class="form-text">Accepted formats: JPG, PNG, JPEG</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="acct_password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="acct_password"
                                            maxlength="20" required placeholder="Password" name="acct_password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword"
                                            maxlength="20" required placeholder="Confirm Password"
                                            name="confirmPassword">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="g-recaptcha"
                                    data-sitekey="<?= htmlspecialchars($page['sitekey'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>

                            <div class="nav-buttons">
                                <button type="button" class="btn btn-outline-secondary prev-section"
                                    data-prev="2"><i class="fas fa-arrow-left me-2"></i> Back</button>
                                <button type="submit" class="btn btn-register" name="regSubmit">Create
                                    Account</button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Already have an account?
                            <a href="./login.php" class="login-link">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        // Multi-step form navigation
        document.querySelectorAll('.next-section').forEach(button => {
            button.addEventListener('click', function() {
                const currentSection = this.closest('.form-section');
                const nextSectionId = this.getAttribute('data-next');

                // Validate current section
                let isValid = true;
                const inputs = currentSection.querySelectorAll('input[required], select[required]');
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (isValid) {
                    currentSection.classList.remove('active');
                    document.getElementById(`section${nextSectionId}`).classList.add('active');

                    // Update progress bar
                    const progress = document.querySelector('.progress-bar');
                    progress.style.width = `${(nextSectionId / 3) * 100}%`;
                } else {
                    alert('Please fill in all required fields before proceeding.');
                }
            });
        });

        document.querySelectorAll('.prev-section').forEach(button => {
            button.addEventListener('click', function() {
                const currentSection = this.closest('.form-section');
                const prevSectionId = this.getAttribute('data-prev');

                currentSection.classList.remove('active');
                document.getElementById(`section${prevSectionId}`).classList.add('active');

                // Update progress bar
                const progress = document.querySelector('.progress-bar');
                progress.style.width = `${(prevSectionId / 3) * 100}%`;
            });
        });

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = this.closest('.input-group').querySelector('input');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-eye-slash"></i>';
            });
        });

        // File upload display
        const fileInput = document.querySelector('.file-upload-input');
        const fileUploadBtn = document.querySelector('.file-upload-btn');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                fileUploadBtn.innerHTML = `<i class="fas fa-check me-2"></i>${this.files[0].name}`;
                fileUploadBtn.classList.add('text-success');
            }
        });

        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            let isValid = true;

            // Check all required fields
            const inputs = this.querySelectorAll('input[required], select[required]');
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Check password match
            const password = document.getElementById('acct_password');
            const confirmPassword = document.getElementById('confirmPassword');

            if (password.value !== confirmPassword.value) {
                isValid = false;
                password.classList.add('is-invalid');
                confirmPassword.classList.add('is-invalid');
                alert('Passwords do not match.');
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });
    </script>
</body>

</html>