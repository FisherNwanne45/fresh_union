<?php
require_once __DIR__ . '/config.php';
$pageName = "Forgot Password";
include_once(ROOT_PATH . "/auth/header.php");
if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
}

// Initialize alert session variable
if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = null;
}

if (isset($_POST['send-link'])) {
    $email = inputValidation($_POST['email']);
    $log = "SELECT * FROM users WHERE acct_email = :email";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'email' => $email
    ]);


    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $validAcct_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($validAcct_email, FILTER_VALIDATE_EMAIL)) {
        // Changed from toast_alert("error", "Invalid email address please type a valid email address!");
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Invalid email address, please type a valid email address!'
        ];
    } elseif ($user['acct_email'] == "") {
        // Changed from toast_alert("error", "No user is registered with this email address!");
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'No user is registered with this email address!'
        ];
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

            // Changed from toast_alert("success", "Password reset link sent to email", "Thanks!");
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Password reset link sent to your email address.'
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">



    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> <?= $pageName ?> - <?= $pageTitle ?> </title>

        <meta name="description" content="<?= $pageTitle ?> Mobile Banking">

        <link rel="shortcut icon" href="<?= $web_url ?>/admin/assets/images/logo/<?= $page['favicon'] ?>"
            type="image/x-icon" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .reset-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .reset-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .reset-body {
            padding: 30px;
        }

        .brand-logo {
            max-width: 180px;
            margin-bottom: 15px;
        }

        .security-icon {
            margin-bottom: 20px;
        }

        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
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

        .btn-reset {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-reset:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .login-link {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .instructions {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--accent-color);
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #6c757d;
            margin: 0 10px;
            position: relative;
        }

        .step.active {
            background: var(--accent-color);
            color: white;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -20px;
            width: 20px;
            height: 2px;
            background: #e9ecef;
        }

        .step.active:not(:last-child)::after {
            background: var(--accent-color);
        }

        @media (max-width: 576px) {
            .reset-container {
                margin: 20px;
            }

            .reset-header,
            .reset-body {
                padding: 20px;
            }
        }
        </style>

    </head>



    <body>
        <?php if (!empty($_SESSION['alert'])): ?>
        <div class="position-fixed top-0 start-50 translate-middle-x mt-3"
            style="z-index: 1050; width: 90%; max-width: 450px;">
            <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show shadow-lg"
                role="alert">
                <i
                    class="fas fa-<?= ($_SESSION['alert']['type'] == 'success') ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
                **<?= ($_SESSION['alert']['type'] == 'success') ? 'Success!' : 'Error!' ?>**
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php $_SESSION['alert'] = null; // Clear the alert after displaying 
        ?>
        <?php endif; ?>
        <div class="container">
            <div class="reset-container">
                <div class="reset-header">
                    <div class="security-icon">
                        <div class="avatar">
                            <i class="fas fa-key text-white fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="mb-2">Reset Your Password</h3>
                    <p class="mb-0">Secure access to your wallet account</p>
                </div>

                <div class="reset-body">
                    <div class="step-indicator">
                        <div class="step active">1</div>
                        <div class="step">2</div>
                        <div class="step">3</div>
                    </div>

                    <div class="instructions">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-primary mt-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-0">Enter the email address associated with
                                    your <?= $pageTitle ?> account.
                                    We'll send you a secure link to reset your
                                    password.</p>
                            </div>
                        </div>
                    </div>

                    <form method="post" class="signin_validate">
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your registered email address" required>
                            </div>
                            <div class="form-text">We'll never share your email with anyone
                                else.</div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" name="send-link" class="btn btn-reset">
                                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">
                                <a href="./login.php" class="login-link">
                                    <i class="fas fa-arrow-left me-1"></i>Back to
                                    Login
                                </a>
                            </p>
                        </div>
                    </form>

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shield-alt text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">
                                    <strong>Security Notice:</strong> The password
                                    reset link will expire after 24 hours
                                    for your protection.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('.signin_validate');
            const emailInput = document.getElementById('email');

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Email validation
                if (!emailInput.value.trim()) {
                    isValid = false;
                    emailInput.classList.add('is-invalid');
                } else {
                    emailInput.classList.remove('is-invalid');

                    // Basic email format validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailInput.value)) {
                        isValid = false;
                        emailInput.classList.add('is-invalid');
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Please enter a valid email address.');
                }
            });

            // Real-time email validation
            emailInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
        </script>

    </body>

</html>