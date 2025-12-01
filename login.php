<?php
require_once __DIR__ . '/config.php';
require_once ROOT_PATH . '/include/config.php';
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
        $_SESSION['alert_type'] = 'error';
        $_SESSION['alert_message'] = 'Invalid login details';
    } else {
        $validPassword = password_verify($acct_password, $user['acct_password']);
        if ($validPassword === false) {
            $_SESSION['alert_type'] = 'error';
            $_SESSION['alert_message'] = 'Invalid login details';
        } else {
            if ($user['acct_status'] === 'hold') {
                $_SESSION['alert_type'] = 'error';
                $_SESSION['alert_message'] = 'Account on Hold, Kindly contact support to activate your account';
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
        }

        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 1000px;
            margin: 0 auto;
        }

        .login-left {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right {
            padding: 40px;
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

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            border: none;
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
            background: transparent;
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

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .register-link {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 400px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            margin-bottom: 10px;
            animation: slideInRight 0.3s ease-out;
        }

        .alert-dismissible .btn-close {
            padding: 0.75rem;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .login-left {
                padding: 30px;
            }

            .login-right {
                padding: 30px;
            }

            .alert-container {
                left: 20px;
                right: 20px;
                max-width: none;
            }
        }
        </style>
    </head>

    <body>
        <!-- Alert Container -->
        <div class="alert-container">
            <?php
        // Function to show bootstrap alert
        function show_bootstrap_alert($type, $message, $title = '')
        {
            $alert_class = '';
            $icon = '';

            switch ($type) {
                case 'error':
                    $alert_class = 'alert-danger';
                    $icon = 'fas fa-exclamation-triangle';
                    break;
                case 'success':
                    $alert_class = 'alert-success';
                    $icon = 'fas fa-check-circle';
                    break;
                case 'warning':
                    $alert_class = 'alert-warning';
                    $icon = 'fas fa-exclamation-circle';
                    break;
                case 'info':
                    $alert_class = 'alert-info';
                    $icon = 'fas fa-info-circle';
                    break;
                default:
                    $alert_class = 'alert-primary';
                    $icon = 'fas fa-bell';
            }

            $title_html = $title ? "<h6 class='alert-heading'><i class='{$icon} me-2'></i>{$title}</h6>" : "<i class='{$icon} me-2'></i>";

            echo "
                <div class='alert {$alert_class} alert-dismissible fade show' role='alert'>
                    {$title_html}
                    {$message}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }

        // Check for error messages and display as bootstrap alerts
        if (isset($_SESSION['alert_message'])) {
            $alert_type = $_SESSION['alert_type'] ?? 'error';
            $alert_message = $_SESSION['alert_message'];
            $alert_title = $_SESSION['alert_title'] ?? '';

            show_bootstrap_alert($alert_type, $alert_message, $alert_title);

            // Clear the session variables
            unset($_SESSION['alert_message']);
            unset($_SESSION['alert_type']);
            unset($_SESSION['alert_title']);
        }
        ?>
        </div>

        <div class="container">
            <div class="login-container">
                <div class="row g-0">
                    <!-- Left Side - Branding & Features -->
                    <div class="col-lg-6 login-left">
                        <div class="text-center mb-4">
                            <img src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>" alt="Wallet Logo"
                                class="brand-logo">
                        </div>
                        <h2 class="mb-3">Secure Access</h2>
                        <p class="mb-4">Manage your finances safely and conveniently with our advanced security
                            features.</p>

                        <ul class="feature-list">
                            <li><i class="fas fa-shield-alt"></i> Bank-level security & encryption</li>
                            <li><i class="fas fa-bolt"></i> Instant transaction processing</li>
                            <li><i class="fas fa-mobile-alt"></i> Mobile-friendly interface</li>
                            <li><i class="fas fa-headset"></i> 24/7 customer support</li>
                        </ul>

                        <div class="security-badge">
                            <i class="fas fa-lock"></i> Your information is securely encrypted
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="col-lg-6 login-right">
                        <h3 class="mb-4">Sign In to Your Account</h3>

                        <ul class="nav nav-tabs" id="loginTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="account-tab" data-bs-toggle="tab"
                                    data-bs-target="#account" type="button" role="tab" aria-controls="account"
                                    aria-selected="true">
                                    <i class="fas fa-user-circle me-2"></i>Account ID
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email"
                                    type="button" role="tab" aria-controls="email" aria-selected="false">
                                    <i class="fas fa-envelope me-2"></i>Email Access
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="loginTabsContent">
                            <!-- Account ID Login -->
                            <div class="tab-pane fade show active" id="account" role="tabpanel"
                                aria-labelledby="account-tab">
                                <form method="post" class="signin_validate">
                                    <div class="mb-3">
                                        <label for="acct_no" class="form-label">Account ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="number" class="form-control" id="acct_no" name="acct_no"
                                                placeholder="Enter your account ID" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="acct_password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="acct_password"
                                                name="acct_password" placeholder="Enter your password" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="togglePassword1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="reset-password.php" class="forgot-password">Forgot Password?</a>
                                    </div>

                                    <button type="submit" name="login" class="btn btn-login w-100 mb-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>

                                    <div class="text-center">
                                        <p class="mb-0">Don't have an account?
                                            <a href="./opening.php" class="register-link">Register here</a>
                                        </p>
                                    </div>
                                </form>
                            </div>

                            <!-- Email Login -->
                            <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                                <form method="post" class="signin_validate">
                                    <div class="mb-3">
                                        <label for="acct_email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="acct_email" name="acct_email"
                                                placeholder="Enter your email address" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="acct_password2" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="acct_password2"
                                                name="acct_password" placeholder="Enter your password" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="togglePassword2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberMe2">
                                            <label class="form-check-label" for="rememberMe2">Remember me</label>
                                        </div>
                                        <a href="reset-password.php" class="forgot-password">Forgot Password?</a>
                                    </div>

                                    <button type="submit" name="emaillogin" class="btn btn-login w-100 mb-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>

                                    <div class="text-center">
                                        <p class="mb-0">Don't have an account?
                                            <a href="./opening.php" class="register-link">Register here</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        // Toggle password visibility
        document.getElementById('togglePassword1').addEventListener('click', function() {
            const passwordInput = document.getElementById('acct_password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });

        document.getElementById('togglePassword2').addEventListener('click', function() {
            const passwordInput = document.getElementById('acct_password2');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });

        // Form validation
        document.querySelectorAll('.signin_validate').forEach(form => {
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Check required fields
                const inputs = this.querySelectorAll('input[required]');
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Show bootstrap alert for form validation
                    showBootstrapAlert('warning', 'Please fill in all required fields.',
                        'Form Incomplete');
                }
            });
        });

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Function to show bootstrap alert dynamically
        function showBootstrapAlert(type, message, title = '') {
            const alertContainer = document.querySelector('.alert-container');
            const alertClass = `alert-${type === 'error' ? 'danger' : type}`;
            const icons = {
                'error': 'exclamation-triangle',
                'success': 'check-circle',
                'warning': 'exclamation-circle',
                'info': 'info-circle'
            };
            const icon = icons[type] || 'bell';

            const titleHtml = title ? `<h6 class="alert-heading"><i class="fas fa-${icon} me-2"></i>${title}</h6>` :
                `<i class="fas fa-${icon} me-2"></i>`;

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${titleHtml}
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            alertContainer.insertAdjacentHTML('beforeend', alertHtml);

            // Auto remove after 5 seconds
            const newAlert = alertContainer.lastElementChild;
            setTimeout(() => {
                if (newAlert) {
                    const bsAlert = new bootstrap.Alert(newAlert);
                    bsAlert.close();
                }
            }, 5000);
        }
        </script>
    </body>

</html>