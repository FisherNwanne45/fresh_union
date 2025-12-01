<?php
require_once __DIR__ . '/../config.php';
$current_page = 'settings-password';
$page_title = 'Password Settings';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    exit;
}

if (isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    if (empty($old_password)) {
        $_SESSION['error_message'] = 'Please enter your current password';
    } elseif (empty($new_password) || empty($confirm_password)) {
        $_SESSION['error_message'] = 'Please enter both new password and confirm password';
    } else {
        $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
        $verification = password_verify($old_password, $row['acct_password']);

        if ($verification === false) {
            $_SESSION['error_message'] = "Incorrect current password";
        } else if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "New password and confirm password do not match";
        } else if ($new_password === $old_password) {
            $_SESSION['error_message'] = 'New password cannot be the same as current password';
        } else if (strlen($new_password) < 8) {
            $_SESSION['error_message'] = 'Password must be at least 8 characters long';
        } else {
            $sql2 = "UPDATE users SET acct_password=:acct_password, confirm_password=:confirm_password WHERE id =:id";
            $passwordUpdate = $conn->prepare($sql2);
            $passwordUpdate->execute([
                'acct_password' => $new_password2,
                'confirm_password' => $confirm_password,
                'id' => $user_id
            ]);

            $full_name = $row['firstname'] . " " . $row['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['url_address'];
            $user_email = $row['acct_email'];
            $user_acctno = $row['acct_no'];
            $message = $sendMail->PasswordMsg($full_name, $user_acctno, $APP_NAME, $APP_URL, $SITE_ADDRESS);

            $subject = "Password Change" . "-" . $APP_NAME;
            $email_message->send_mail($user_email, $message, $subject);

            $_SESSION['success_message'] = $passwordUpdate ? 'Password changed successfully!' : 'Failed to update password. Please try again.';
        }
    }

    // Redirect after processing
    @header("Location: settings-password.php");
    echo "<script>window.location.href='settings-password.php';</script>";
    exit;
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Password Settings</h2>
    <a href="settings-profile.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i> Back to Profile
    </a>
</div>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success solid alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger solid alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $_SESSION['error_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <!-- Change Password Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-lock me-2 text-primary"></i>
                    Change Password
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Update your account password for enhanced security</p>

                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control form-control-lg" name="old_password"
                                    autocomplete="off" placeholder="Enter current password" required>
                                <small class="form-text text-muted">Enter your current password</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control form-control-lg" name="new_password"
                                    autocomplete="off" placeholder="Enter new password" required>
                                <small class="form-text text-muted">Choose a strong, unique password</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control form-control-lg" name="confirm_password"
                                    autocomplete="off" placeholder="Confirm new password" required>
                                <small class="form-text text-muted">Re-enter your new password</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg" name="change_password">
                                <i class="fas fa-lock me-2"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Security Card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                    Password Security
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item" data-bs-toggle="collapse" data-bs-target="#passwordTips">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon bg-info me-3">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Password Best Practices</h6>
                                <p class="mb-0 text-muted small">How to create a strong and secure password</p>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-chevron-right collapse-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="passwordTips">
                        <div class="p-3 bg-light border-top">
                            <ul class="mb-0">
                                <li>Use at least 12 characters</li>
                                <li>Include uppercase and lowercase letters</li>
                                <li>Add numbers and special characters</li>
                                <li>Avoid common words and personal information</li>
                                <li>Don't reuse passwords across different sites</li>
                                <li>Consider using a passphrase instead of a single word</li>
                            </ul>
                        </div>
                    </div>

                    <div class="list-group-item" data-bs-toggle="collapse" data-bs-target="#recoveryInfo">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon bg-warning me-3">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Forgot Your Password?</h6>
                                <p class="mb-0 text-muted small">What to do if you forget your password</p>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-chevron-right collapse-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="recoveryInfo">
                        <div class="p-3 bg-light border-top">
                            <ol class="mb-3">
                                <li>Click "Forgot Password" on the login page</li>
                                <li>Enter your registered email address</li>
                                <li>Check your email for a password reset link</li>
                                <li>Click the link and create a new password</li>
                                <li>If you don't receive the email, check your spam folder</li>
                            </ol>
                            <div class="alert alert-warning mt-2 mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Note:</strong> Ensure your email address is up to date for recovery.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include PIN-style CSS/JS from previous page -->
<style>
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        letter-spacing: 0.1em;
    }

    .card {
        border: none;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }

    .card-header {
        background: white;
        border-bottom: 1px solid #eaeaea;
        padding: 1.25rem 1.5rem;
        border-radius: 12px 12px 0 0 !important;
    }

    .card-header .card-title {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .list-group-item {
        border: none;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .setting-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .setting-icon i {
        font-size: 1.1rem;
    }

    .collapse-icon {
        transition: transform 0.3s ease;
    }

    .list-group-item[aria-expanded="true"] .collapse-icon {
        transform: rotate(90deg);
    }

    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .list-group-item {
            padding: 1rem;
        }

        .setting-icon {
            width: 42px;
            height: 42px;
        }

        .form-control-lg {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 1rem;
        }

        .list-group-item {
            padding: 0.875rem;
        }

        .setting-icon {
            width: 38px;
            height: 38px;
            margin-right: 0.875rem !important;
        }

        .setting-icon i {
            font-size: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const collapseItems = document.querySelectorAll('.list-group-item[data-bs-toggle="collapse"]');
        collapseItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                const isExpanded = target.classList.contains('show');
                this.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            });
        });

        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) alert.parentNode.removeChild(alert);
                    }, 300);
                }
            }, 5000);
        });
    });
</script>

<?php include 'layout/footer.php'; ?>