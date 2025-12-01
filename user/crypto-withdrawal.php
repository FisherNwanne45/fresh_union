<?php
require_once __DIR__ . '/../config.php';
$current_page = 'withdrawal';
$page_title = 'Crypto Withdrawal';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

// Initialize alert variables
$alert_type = '';
$alert_message = '';
$alert_title = '';

if (isset($_POST['withdraw'])) {
    $amount = $_POST['amount'];
    $crypto_name = $_POST['crypto_name'];
    $account_name = $_POST['wallet_address'];
    $user_id = userDetails('id');

    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);

    if (empty($amount) || empty($crypto_name) || empty($account_name)) {
        $alert_type = 'danger';
        $alert_message = 'Please fill all required fields.';
        $alert_title = 'Missing Information';
    } elseif ($pin !== $oldPin) {
        $alert_type = 'danger';
        $alert_message = 'The transaction pin you entered is incorrect.';
        $alert_title = 'Invalid Pin';
    } elseif ($amount > $row['acct_balance']) {
        $alert_type = 'warning';
        $alert_message = 'You cannot withdraw more than your available balance.';
        $alert_title = 'Insufficient Balance';
    } else {
        $available_balance = ($row['acct_balance'] - $amount);

        $sql = "UPDATE users SET acct_balance=:available_balance WHERE id=:user_id";
        $addUp = $conn->prepare($sql);
        $addUp->execute([
            'available_balance' => $available_balance,
            'user_id' => $user_id
        ]);

        $refrence_id = uniqid();
        $trans_type = "Crypto Withdrawal";
        $transaction_type = "debit";
        $trans_status = "processing";
        $account_number = "N/A";

        $sql = "INSERT INTO transactions (amount,refrence_id,user_id,crypto_id,account_name,account_number,trans_type,transaction_type,trans_status) VALUES(:amount,:refrence_id,:user_id,:crypto_id,:account_name,:account_number,:trans_type,:transaction_type,:trans_status)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'user_id' => $user_id,
            'crypto_id' => $crypto_name,
            'account_name' => $account_name,
            'account_number' => $account_number,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status
        ]);

        if ($tranfered) {
            $full_name = $row['firstname'] . " " . $row['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['url_address'];
            $user_email = $row['acct_email'];
            $acct_currency = $row['acct_currency'];
            $message = $sendMail->WithdrawMsg($full_name, $amount, $trans_type, $trans_status, $refrence_id, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Crypto Withdrawal" . "-" . $APP_NAME;
            $email_message->send_mail($user_email, $message, $subject);

            $alert_type = 'success';
            $alert_message = 'Your withdrawal request has been submitted successfully and is being processed. You will receive a confirmation email shortly.';
            $alert_title = 'Withdrawal Request Submitted!';

            // Clear form fields on success
            echo '<script>document.addEventListener("DOMContentLoaded", function() { document.querySelector("form").reset(); });</script>';
        } else {
            $alert_type = 'danger';
            $alert_message = 'An error occurred while processing your withdrawal. Please try again or contact support if the problem persists.';
            $alert_title = 'Processing Error';
        }
    }
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-2">Crypto Withdrawal</h2>
    <a href="#" onclick="location.reload();" class="btn btn-primary btn-sm w-20">
        <i class="fas fa-refresh me-2"></i>Refresh
    </a>
</div>

<!-- Alert Messages -->
<?php if (!empty($alert_message)): ?>
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <?php if ($alert_type == 'success'): ?>
                            <i class="fas fa-check-circle fa-2x"></i>
                        <?php elseif ($alert_type == 'danger'): ?>
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        <?php elseif ($alert_type == 'warning'): ?>
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <?php else: ?>
                            <i class="fas fa-info-circle fa-2x"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="alert-heading mb-1"><?= $alert_title ?></h5>
                        <p class="mb-0"><?= $alert_message ?></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
        <!-- Balance Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="balance-item">
                            <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle mx-auto mb-3">
                                <i class="fas fa-wallet text-success fa-2x"></i>
                            </div>
                            <h6 class="text-muted mb-2">Available Balance</h6>
                            <h4 class="text-success fw-bold">
                                <?= $currency ?><?= number_format($row['acct_balance'], 2) ?></h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="balance-item">
                            <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle mx-auto mb-3">
                                <i class="fas fa-exchange-alt text-primary fa-2x"></i>
                            </div>
                            <h6 class="text-muted mb-2">Daily Limit</h6>
                            <h4 class="text-primary fw-bold">
                                <?= $currency ?><?= number_format($row['limit_remain'], 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Form Card -->
        <div class="card border-0 bg-light shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-1">Crypto Withdrawal Details</h5>
                <p class="text-muted mb-0">Enter your cryptocurrency withdrawal information</p>
            </div>
            <div class="card-body">
                <!-- Processing Info -->
                <div class="alert alert-info bg-light border-0 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <div>
                            <strong>Processing Time:</strong> Crypto withdrawals are typically processed within 2-4
                            hours during business days.
                        </div>
                    </div>
                </div>

                <form method="POST" class="needs-validation" novalidate>
                    <!-- Amount -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <input type="number" class="form-control ps-2" id="amount" name="amount"
                                    placeholder="0.00" step="0.01" min="0.01" max="<?= $row['acct_balance'] ?>"
                                    value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter a valid amount within your available balance.
                                </div>
                            </div>
                            <div class="form-text text-muted mt-1">
                                Maximum withdrawal: <?= $currency ?><?= number_format($row['acct_balance'], 2) ?>
                            </div>
                        </div>

                        <!-- Crypto Type -->
                        <div class="col-md-6 mb-3">
                            <label for="crypto_name" class="form-label">Crypto Type <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fab fa-bitcoin"></i>
                                </span>
                                <select name="crypto_name" id="crypto_name" class="form-control ps-2" required>
                                    <option value="">Select Crypto Type</option>
                                    <?php
                                    $sql = $conn->query("SELECT * FROM crypto_currency ORDER BY crypto_name");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = (isset($_POST['crypto_name']) && $_POST['crypto_name'] == $rs['id']) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $rs['id'] ?>" <?= $selected ?>><?= ucwords($rs['crypto_name']) ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a crypto type.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Crypto Wallet Address -->
                    <div class="mb-3">
                        <label for="wallet_address" class="form-label">Crypto Wallet Address <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-end-0">
                                <i class="fas fa-wallet"></i>
                            </span>
                            <input type="text" class="form-control ps-2" id="wallet_address" name="wallet_address"
                                placeholder="Enter your crypto wallet address"
                                value="<?= isset($_POST['wallet_address']) ? htmlspecialchars($_POST['wallet_address']) : '' ?>"
                                required>
                            <div class="invalid-feedback">
                                Please enter your crypto wallet address.
                            </div>
                        </div>
                        <div class="form-text text-muted mt-1">
                            Double-check your wallet address to ensure it's correct.
                        </div>
                    </div>

                    <!-- Transaction Pin -->
                    <div class="mb-4">
                        <label for="pin" class="form-label">Transaction Pin <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-end-0">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control ps-2" id="pin" name="pin" inputmode="numeric"
                                pattern="[0-9]{4}" maxlength="4" placeholder="Enter your 4-digit transaction pin"
                                required>
                            <div class="invalid-feedback">
                                Please enter your 4-digit transaction pin.
                            </div>
                        </div>
                        <div class="form-text text-muted mt-1">
                            <a href="ticket.php" class="text-decoration-none">
                                <i class="fas fa-question-circle me-1"></i>Forgot your transaction pin?
                            </a>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions mt-4 pt-3 border-top">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="transfer.php" class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Go Back
                                </a>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-lg w-100" name="withdraw">
                                    <i class="fas fa-paper-plane me-2"></i>Withdraw Funds
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Info Cards -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Withdrawal Guidelines
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Minimum withdrawal: <?= $currency ?>10.00
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                No withdrawal fees
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                2-4 hour processing time
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Available 24/7
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            Security Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Verify wallet address carefully
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Keep your transaction pin secure
                            </li>
                            <li>
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Contact support for suspicious activity
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Withdrawals Card -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Withdrawals</h5>
                <a href="transactions.php" class="btn btn-link btn-sm p-0">View All</a>
            </div>
            <div class="card-body">
                <?php
                $sql = $conn->prepare("SELECT * FROM transactions WHERE user_id = :user_id AND trans_type = 'Crypto Withdrawal' ORDER BY created_at DESC LIMIT 5");
                $sql->execute(['user_id' => $user_id]);
                $recent_withdrawals = $sql->fetchAll(PDO::FETCH_ASSOC);

                if (count($recent_withdrawals) > 0) {
                    foreach ($recent_withdrawals as $withdrawal) {
                ?>
                        <div class="transfer-item d-flex align-items-center py-3 border-bottom">
                            <div class="transfer-icon flex-shrink-0">
                                <div class="avatar avatar-sm bg-danger bg-opacity-10 rounded-circle">
                                    <i class="fas fa-arrow-up text-danger"></i>
                                </div>
                            </div>
                            <div class="transfer-details flex-grow-1 ms-3">
                                <h6 class="mb-1">Crypto Withdrawal</h6>
                                <p class="text-muted small mb-0">Ref: #<?= $withdrawal['refrence_id'] ?></p>
                            </div>
                            <div class="transfer-amount text-end">
                                <h6 class="mb-1 text-danger">-<?= $currency ?><?= number_format($withdrawal['amount'], 2) ?>
                                </h6>
                                <span
                                    class="badge bg-<?= $withdrawal['trans_status'] == 'completed' ? 'success' : ($withdrawal['trans_status'] == 'processing' ? 'warning' : 'danger') ?>-subtle text-<?= $withdrawal['trans_status'] == 'completed' ? 'success' : ($withdrawal['trans_status'] == 'processing' ? 'warning' : 'danger') ?> small">
                                    <?= ucfirst($withdrawal['trans_status']) ?>
                                </span>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="text-center py-4">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-exchange-alt fa-2x text-muted"></i>
                            </div>
                            <h6 class="text-muted">No recent withdrawals</h6>
                            <p class="text-muted small">Your withdrawal history will appear here</p>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        border: 1px solid #eef2f7;
    }

    .card-header {
        padding: 1.5rem 1.5rem 0.5rem;
        background: transparent;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .input-group-text {
        border: 1px solid #e2e8f0;
        border-right: none;
        min-width: 45px;
        justify-content: center;
    }

    .form-control,
    .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        height: auto;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.1);
    }

    .form-control.ps-2 {
        padding-left: 0.75rem;
    }

    .alert {
        border-radius: 8px;
    }

    .alert-info {
        background-color: rgba(var(--primary-rgb), 0.05);
        border: 1px solid rgba(var(--primary-rgb), 0.1);
    }

    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-lg {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }

    .form-actions {
        border-top: 1px solid #eef2f7;
    }

    .transfer-item {
        transition: background-color 0.2s ease;
    }

    .transfer-item:hover {
        background-color: #fafbfe;
        border-radius: 8px;
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    .empty-state-icon {
        opacity: 0.5;
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    /* Professional color adjustments */
    :root {
        --primary-rgb: 30, 170, 231;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .transfer-item {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .transfer-details {
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }

        .form-head {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .form-head .btn {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Amount validation
        const amountInput = document.getElementById('amount');
        const maxAmount = <?= $row['acct_balance'] ?>;

        amountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;

            if (amount > maxAmount) {
                this.setCustomValidity('Amount exceeds available balance');
            } else {
                this.setCustomValidity('');
            }
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Add smooth animations
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'fadeInUp 0.6s ease-out';
        });
    });

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
`;
    document.head.appendChild(style);
</script>

<?php include 'layout/footer.php'; ?>