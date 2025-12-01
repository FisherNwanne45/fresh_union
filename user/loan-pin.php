<?php
require_once __DIR__ . '/../config.php';
$current_page = 'loan-pin';
$page_title = 'Verify PIN';
include 'layout/header.php';

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
require_once(ROOT_PATH . "/include/Transfer/Function.php");

if (!isset($_SESSION['is_dom_transfer'])) {
    header("Location: ./dashboard.php");
    exit();
}

// Process form submission - EXACTLY LIKE YOUR ORIGINAL
if (isset($_POST['loan_submit'])) {
    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);
    $user_id = inputValidation($_POST['user_id']);
    $amount = inputValidation($_POST['amount']);
    $account_name = inputValidation($_POST['account_name']);

    if ($pin !== $oldPin) {
        $_SESSION['error_message'] = 'Incorrect PIN code';
    } else if ($acct_amount < 0) {
        $_SESSION['error_message'] = 'Insufficient Balance';
    } else {
        $refrence_id = uniqid();
        $trans_type = "Loan";
        $transaction_type = "credit";
        $trans_status = "processing";

        $sql = "INSERT INTO transactions (amount, refrence_id, user_id, account_name, trans_type, transaction_type, trans_status) 
                VALUES(:amount, :refrence_id, :user_id, :account_name, :trans_type, :transaction_type, :trans_status)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'user_id' => $user_id,
            'account_name' => $account_name,
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
            $user_acctno = $row['acct_no'];

            if (isset($sendMail) && method_exists($sendMail, 'LoanMsg')) {
                $message = $sendMail->LoanMsg($full_name, $amount, $user_acctno, $trans_type, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                $subject = "Loan Notification" . "-" . $APP_NAME;

                if (isset($email_message) && method_exists($email_message, 'send_mail')) {
                    $email_message->send_mail($user_email, $message, $subject);
                }
            }

            $_SESSION['dom_transfer'] = $refrence_id;
            $_SESSION['is_transfer'] = "transfer";

            // Clear output buffer and redirect
            while (ob_get_level()) {
                ob_end_clean();
            }

            header("Location: ./success.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Sorry, an error occurred. Please contact support.";
        }
    }
}

// TEMP TRANSACTION FETCH
$sql = "SELECT * FROM temp_trans WHERE user_id = :user_id AND trans_type='Loan' ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$temp_trans = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$temp_trans) {
    header("Location: ./loan-request.php");
    exit();
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Verify PIN</h2>
    <a href="<?= $web_url ?>/user/loan-preview.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Error Messages -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $_SESSION['error_message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <div class="text-center mb-5">
                    <div class="pin-icon bg-primary mb-4 mx-auto">
                        <i class="fas fa-lock fa-2x text-white"></i>
                    </div>
                    <h2 class="pin-title">Enter Your PIN</h2>
                    <p class="text-muted">Enter your 4-digit security PIN to confirm your loan application</p>
                </div>

                <!-- Transaction Summary -->
                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-receipt me-2 text-primary"></i>Transaction Summary
                        </h5>
                        <div class="transaction-details">
                            <div class="transaction-item">
                                <span class="transaction-label">Loan Amount</span>
                                <span
                                    class="transaction-value"><?= $currency ?><?= number_format($temp_trans['amount'], 2, '.', ',') ?></span>
                            </div>
                            <div class="transaction-item">
                                <span class="transaction-label">Purpose</span>
                                <span
                                    class="transaction-value"><?= htmlspecialchars($temp_trans['account_name']) ?></span>
                            </div>
                            <div class="transaction-item">
                                <span class="transaction-label">Reference ID</span>
                                <span class="transaction-value">#<?= $temp_trans['refrence_id'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIMPLE FORM - NO JAVASCRIPT, NO AJAX -->
                <form method="POST">
                    <div class="form-group mb-4">
                        <label class="form-label text-center d-block mb-3">Enter 4-Digit PIN</label>
                        <div class="pin-input-container mx-auto">
                            <input type="password" name="pin" class="form-control form-control-lg text-center pin-input"
                                autocomplete="off" id="pin" placeholder="••••" maxlength="4" minlength="4"
                                inputmode="numeric" pattern="[0-9]*" required>
                        </div>
                        <small class="form-text text-muted text-center d-block mt-2">
                            Enter the same PIN you use for transactions
                        </small>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="amount" value="<?= $temp_trans['amount'] ?>">
                    <input type="hidden" name="account_name"
                        value="<?= htmlspecialchars($temp_trans['account_name']) ?>">
                    <input type="hidden" name="user_id" value="<?= $temp_trans['user_id'] ?>">

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-lg w-100" name="loan_submit">
                            <i class="fas fa-check me-2"></i> Confirm Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .pin-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
    }

    .pin-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .pin-input-container {
        max-width: 200px;
        margin: 0 auto;
    }

    .pin-input {
        font-size: 1.5rem !important;
        font-weight: 700;
        letter-spacing: 0.5em;
        padding-left: 0.75rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .pin-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .transaction-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-label {
        font-weight: 600;
        color: #6c757d;
    }

    .transaction-value {
        font-weight: 500;
        color: #2c3e50;
        text-align: right;
    }

    .form-button-group {
        margin-top: 2rem;
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .pin-input-container {
            max-width: 180px;
        }

        .pin-input {
            font-size: 1.25rem !important;
            letter-spacing: 0.4em;
        }
    }

    @media (max-width: 576px) {
        .transaction-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .transaction-label,
        .transaction-value {
            width: 100%;
            text-align: left;
        }
    }
</style>

<script>
    // SIMPLE JAVASCRIPT - ONLY FOR PIN INPUT FORMATTING, NO FORM SUBMISSION
    document.addEventListener('DOMContentLoaded', function() {
        const pinInput = document.getElementById('pin');

        // PIN input formatting only
        if (pinInput) {
            pinInput.addEventListener('input', function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Prevent non-numeric input
            pinInput.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Focus on PIN input when page loads
            pinInput.focus();
        }

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