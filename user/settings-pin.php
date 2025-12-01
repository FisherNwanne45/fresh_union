<?php
require_once __DIR__ . '/../config.php';
$current_page = 'settings-pin';
$page_title = 'PIN Settings';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

if (isset($_POST['change_pin'])) {
    $current_pin = inputValidation($_POST['current_pin']);
    $new_pin = inputValidation($_POST['new_pin']);
    $confirm_pin = inputValidation($_POST['confirm_pin']);
    $verify_pin = $row['acct_pin'];

    if ($current_pin !== $verify_pin) {
        $_SESSION['error_message'] = 'Invalid current PIN';
    } else if ($new_pin !== $confirm_pin) {
        $_SESSION['error_message'] = 'New PIN and confirm PIN do not match';
    } else if ($new_pin === $verify_pin) {
        $_SESSION['error_message'] = 'New PIN cannot be the same as current PIN';
    } else if (strlen($new_pin) !== 4 || !is_numeric($new_pin)) {
        $_SESSION['error_message'] = 'PIN must be exactly 4 digits';
    } else {
        $sql2 = "UPDATE users SET acct_pin=:acct_pin WHERE id =:id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_pin' => $new_pin,
            'id' => $user_id
        ]);

        $full_name = $row['firstname'] . " " . $row['lastname'];
        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $SITE_ADDRESS = $page['url_address'];
        $user_email = $row['acct_email'];
        $user_acctno = $row['acct_no'];
        $message = $sendMail->PinMsg($full_name, $user_acctno, $APP_NAME, $APP_URL, $SITE_ADDRESS);

        $subject = "PIN Change" . "-" . $APP_NAME;
        $email_message->send_mail($user_email, $message, $subject);

        if ($passwordUpdate) {
            $_SESSION['success_message'] = 'PIN changed successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to update PIN. Please try again.';
        }
    }

    // Redirect to show message
    // Try normal header redirect first
    @header("Location: settings-pin.php");

    // If headers were already sent, use JS redirect fallback
    echo "<script>window.location.href='settings-pin.php';</script>";

    // Hard exit
    exit;
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">PIN Settings</h2>
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
        <!-- Change PIN Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-key me-2 text-primary"></i>
                    Change Transaction PIN
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Update your 4-digit security PIN used for transactions</p>

                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Current PIN</label>
                                <input type="password" inputmode="numeric" pattern="[0-9]*" minlength="4" maxlength="4"
                                    class="form-control form-control-lg" name="current_pin" autocomplete="off"
                                    placeholder="Enter current PIN" required>
                                <small class="form-text text-muted">Enter your current 4-digit PIN</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">New PIN</label>
                                <input type="password" inputmode="numeric" pattern="[0-9]*" minlength="4" maxlength="4"
                                    class="form-control form-control-lg" name="new_pin" autocomplete="off"
                                    placeholder="Enter new PIN" required>
                                <small class="form-text text-muted">Choose a new 4-digit PIN</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Confirm New PIN</label>
                                <input type="password" inputmode="numeric" pattern="[0-9]*" minlength="4" maxlength="4"
                                    class="form-control form-control-lg" name="confirm_pin" autocomplete="off"
                                    placeholder="Confirm new PIN" required>
                                <small class="form-text text-muted">Re-enter your new PIN</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg" name="change_pin">
                                <i class="fas fa-key me-2"></i> Update PIN
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- PIN Security Card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                    PIN Security
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item" data-bs-toggle="collapse" data-bs-target="#pinTips">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon bg-info me-3">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">PIN Security Tips</h6>
                                <p class="mb-0 text-muted small">Best practices for choosing a secure PIN</p>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-chevron-right collapse-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="pinTips">
                        <div class="p-3 bg-light border-top">
                            <ul class="mb-0">
                                <li>Don't use obvious sequences (1234, 0000, 1111)</li>
                                <li>Avoid using your birth year or simple patterns</li>
                                <li>Don't share your PIN with anyone</li>
                                <li>Change your PIN regularly</li>
                                <li>Use different PINs for different services</li>
                            </ul>
                        </div>
                    </div>

                    <div class="list-group-item" data-bs-toggle="collapse" data-bs-target="#pinFaq">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon bg-warning me-3">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Forgot Your PIN?</h6>
                                <p class="mb-0 text-muted small">What to do if you forget your transaction PIN</p>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-chevron-right collapse-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="pinFaq">
                        <div class="p-3 bg-light border-top">
                            <p class="mb-2">If you've forgotten your PIN:</p>
                            <ol class="mb-3">
                                <li>Go to the Support section</li>
                                <li>Create a new support ticket</li>
                                <li>Select "Forgot PIN" as the issue type</li>
                                <li>Our team will verify your identity and reset your PIN</li>
                                <li>You'll receive a temporary PIN via email</li>
                            </ol>
                            <div class="alert alert-warning mt-2 mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Note:</strong> PIN reset may take 1-2 business days for security verification.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        // Handle collapse toggle icons
        const collapseItems = document.querySelectorAll('.list-group-item[data-bs-toggle="collapse"]');
        collapseItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                const isExpanded = target.classList.contains('show');

                // Update aria-expanded attribute
                this.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            });
        });

        // PIN input formatting
        const pinInputs = document.querySelectorAll('input[type="password"][inputmode="numeric"]');
        pinInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 4) {
                    this.value = this.value.slice(0, 4);
                }
            });

            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                }
            }, 5000);
        });
    });
</script>


<?php include 'layout/footer.php'; ?>