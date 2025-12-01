<?php
require_once __DIR__ . '/config.php';
$pageName  = "New Password";
include_once(ROOT_PATH . "/auth/header.php");
if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
}

if (isset($_GET['email']) && isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/kolkata');
    $date = date("Y-m-d");
    $email = $_GET['email'];
    $reset_token = $_GET['reset_token'];
} else {
    toast_alert("error", "Sorry Something Went Wrong !");
}

if (isset($_POST['update'])) {
    $confirm_password = inputValidation($_POST['confirm_password']);
    $new_password = inputValidation($_POST['new_password']);
    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);

    $sql2 = "UPDATE users SET acct_password=:acct_password,confirm_password=:confirm_password,resettoken=:resettoken,resettokenexp=:resettokenexp WHERE acct_email=:email";
    $passwordUpdate = $conn->prepare($sql2);
    $passwordUpdate->execute([
        'acct_password' => $new_password2,
        'confirm_password' => $confirm_password,
        'resettoken' => NULL,
        'resettokenexp' => NULL,
        'email' => $email
    ]);

    if (true) {
        $msg1 = "
            <div class='alert alert-warning'>
            
            <script type='text/javascript'>
                 
                    function Redirect() {
                    window.location='./login.php';
                    }
                    document.write ('');
                    setTimeout('Redirect()', 4000);
                 
                    </script>
                    
            <center><img src='./assets/images/loading.gif' width='180px'  /></center>
            
            
            <center>	<strong style='color:black;'>Your Password Change Successfully, Please Wait while we redirect you...
                   </strong></center>
              </div>
            ";
    } else {
        //toast_alert("error", "Sorry Something Went Wrong !");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Set New Password - <?= $pageName ?> - <?= $pageTitle ?> </title>

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

        .password-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .password-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .password-body {
            padding: 30px;
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

        .btn-update {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-update:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .requirements {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--accent-color);
        }

        .requirements ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .requirements li {
            margin-bottom: 5px;
        }

        .requirements li.valid {
            color: var(--success-color);
        }

        .requirements li.invalid {
            color: var(--danger-color);
        }

        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0%;
            transition: width 0.3s;
        }

        .strength-weak {
            background-color: var(--danger-color);
        }

        .strength-medium {
            background-color: var(--warning-color);
        }

        .strength-strong {
            background-color: var(--success-color);
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

        .loading-animation {
            text-align: center;
            padding: 30px;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 576px) {
            .password-container {
                margin: 20px;
            }

            .password-header,
            .password-body {
                padding: 20px;
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

        // Check for error messages
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
            <div class="password-container">
                <!-- Header Section -->
                <div class="password-header">
                    <div class="security-icon">
                        <div class="avatar">
                            <i class="fas fa-key text-white fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="mb-2">Create New Password</h3>
                    <p class="mb-0">Choose a strong, secure password for your account</p>
                </div>

                <!-- Body Section -->
                <div class="password-body">
                    <?php if (isset($msg1)): ?>
                    <!-- Success Message with Loading Animation -->
                    <div class="loading-animation">
                        <div class="loading-spinner"></div>
                        <h4 class="text-primary mb-3">Password Updated Successfully!</h4>
                        <p class="text-muted">Redirecting you to login page...</p>
                    </div>
                    <script>
                    setTimeout(function() {
                        window.location.href = './login.php';
                    }, 4000);
                    </script>
                    <?php else: ?>
                    <?php if (isset($_GET['email']) && isset($_GET['reset_token'])): ?>
                    <div class="requirements">
                        <h6 class="mb-2"><i class="fas fa-shield-alt text-primary me-2"></i>Password Requirements</h6>
                        <ul>
                            <li class="invalid" id="length">At least 6 characters</li>
                            <li class="invalid" id="uppercase">One uppercase letter</li>
                            <li class="invalid" id="lowercase">One lowercase letter</li>
                            <li class="invalid" id="number">One number</li>
                        </ul>
                        <div class="password-strength">
                            <div class="strength-meter" id="strengthMeter"></div>
                        </div>
                    </div>

                    <form method="post" class="signin_validate">
                        <input type="hidden" name="email" value="<?= $email ?>">

                        <div class="mb-4">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="Enter your new password" minlength="6" maxlength="60" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Must be at least 6 characters long</div>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="Confirm your new password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="form-text"></div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" name="update" class="btn btn-update" id="updateBtn" disabled>
                                <i class="fas fa-key me-2"></i>Update Password
                            </button>
                        </div>
                    </form>

                    <!-- Security Information -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-lightbulb text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">
                                    <strong>Tip:</strong> Use a unique password that you don't use on other websites.
                                    Consider using a password manager.
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Invalid or expired password reset link. Please request a new one.
                    </div>
                    <div class="text-center mt-4">
                        <a href="./reset-password.php" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i>Request New Reset Link
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password validation
            const passwordInput = document.getElementById('new_password');
            const confirmInput = document.getElementById('confirm_password');
            const updateBtn = document.getElementById('updateBtn');
            const strengthMeter = document.getElementById('strengthMeter');

            // Password validation requirements
            const requirements = {
                length: document.getElementById('length'),
                uppercase: document.getElementById('uppercase'),
                lowercase: document.getElementById('lowercase'),
                number: document.getElementById('number')
            };

            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('input');
                    const type = input.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    input.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                        '<i class="fas fa-eye-slash"></i>';
                });
            });

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;

                // Check length
                if (password.length >= 6) {
                    strength += 25;
                    requirements.length.classList.remove('invalid');
                    requirements.length.classList.add('valid');
                } else {
                    requirements.length.classList.remove('valid');
                    requirements.length.classList.add('invalid');
                }

                // Check uppercase
                if (/[A-Z]/.test(password)) {
                    strength += 25;
                    requirements.uppercase.classList.remove('invalid');
                    requirements.uppercase.classList.add('valid');
                } else {
                    requirements.uppercase.classList.remove('valid');
                    requirements.uppercase.classList.add('invalid');
                }

                // Check lowercase
                if (/[a-z]/.test(password)) {
                    strength += 25;
                    requirements.lowercase.classList.remove('invalid');
                    requirements.lowercase.classList.add('valid');
                } else {
                    requirements.lowercase.classList.remove('valid');
                    requirements.lowercase.classList.add('invalid');
                }

                // Check numbers
                if (/[0-9]/.test(password)) {
                    strength += 25;
                    requirements.number.classList.remove('invalid');
                    requirements.number.classList.add('valid');
                } else {
                    requirements.number.classList.remove('valid');
                    requirements.number.classList.add('invalid');
                }

                // Update strength meter
                strengthMeter.style.width = strength + '%';
                strengthMeter.className = 'strength-meter';

                if (strength < 50) {
                    strengthMeter.classList.add('strength-weak');
                } else if (strength < 75) {
                    strengthMeter.classList.add('strength-medium');
                } else {
                    strengthMeter.classList.add('strength-strong');
                }

                return strength;
            }

            // Password match checker
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                const matchElement = document.getElementById('passwordMatch');

                if (!password || !confirm) {
                    matchElement.textContent = '';
                    matchElement.className = 'form-text';
                    return false;
                }

                if (password === confirm) {
                    matchElement.innerHTML = '<i class="fas fa-check text-success me-1"></i> Passwords match';
                    matchElement.className = 'form-text text-success';
                    return true;
                } else {
                    matchElement.innerHTML =
                        '<i class="fas fa-times text-danger me-1"></i> Passwords do not match';
                    matchElement.className = 'form-text text-danger';
                    return false;
                }
            }

            // Update button state
            function updateButtonState() {
                const strength = checkPasswordStrength(passwordInput.value);
                const match = checkPasswordMatch();

                updateBtn.disabled = !(strength >= 75 && match && passwordInput.value.length >= 6);
            }

            // Event listeners
            passwordInput.addEventListener('input', updateButtonState);
            confirmInput.addEventListener('input', updateButtonState);

            // Form validation
            const form = document.querySelector('.signin_validate');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (updateBtn.disabled) {
                        e.preventDefault();
                        alert('Please ensure your password meets all requirements and matches.');
                    }
                });
            }

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
        </script>
    </body>

</html>