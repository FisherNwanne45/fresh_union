<?php
require_once __DIR__ . '/../config.php';
$current_page = 'loan';
$page_title = 'Apply for Loan';
include 'layout/header.php';

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
require_once(ROOT_PATH . "/include/Transfer/Function.php");

if (isset($_POST['loan-submit'])) {
    $amount = $_POST['amount'];
    $account_name = $_POST['loan_remarks'];
    $loanlimit = $page['loanlimit'];

    if (empty($amount)) {
        $_SESSION['error_message'] = "Amount is required!";
    } elseif ($amount <= 0) {
        $_SESSION['error_message'] = "Invalid amount!";
    } elseif (empty($account_name)) {
        $_SESSION['error_message'] = "Loan description is required!";
    } elseif ($amount > $loanlimit) {
        $_SESSION['error_message'] = "Loan amount exceeds the maximum limit of " . $currency . number_format($loanlimit, 2);
    } else {
        $refrence_id = uniqid();
        $trans_type = "Loan";
        $transaction_type = "credit";
        $trans_status = "processing";

        $sql = "INSERT INTO temp_trans (amount, refrence_id, user_id, account_name, trans_type, transaction_type, trans_status) VALUES(:amount, :refrence_id, :user_id, :account_name, :trans_type, :transaction_type, :trans_status)";
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
            $_SESSION['is_dom_code'] = "None";
            $_SESSION['is_dom_transfer'] = "Dom";
            $_SESSION['is_transfer'] = "None";
            header("Location: ./loan-preview.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Sorry, an error occurred. Please try again!';
        }
    }

    // Redirect to show error message
    header("Location: loan-request.php");
    exit();
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Apply for Loan</h2>
    <a href="loan.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i>Back to Loans
    </a>
</div>

<!-- Success/Error Messages -->
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
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Loan Application</h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Complete the form below to apply for a loan. Maximum loan amount:
                    <strong><?= $currency ?><?= number_format($page['loanlimit'], 2) ?></strong>
                </p>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">Loan Amount *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><?= $currency ?></span>
                                    <input type="number" class="form-control form-control-lg" name="amount"
                                        placeholder="0.00" step="0.01" min="1" max="<?= $page['loanlimit'] ?>"
                                        value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>"
                                        required>
                                </div>
                                <small class="form-text text-muted">Enter the amount you wish to borrow</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Loan Purpose *</label>
                        <textarea class="form-control" rows="5" name="loan_remarks"
                            placeholder="Please describe the purpose of this loan (e.g., Home renovation, Car purchase, Education expenses, etc.)"
                            required><?= isset($_POST['loan_remarks']) ? htmlspecialchars($_POST['loan_remarks']) : '' ?></textarea>
                        <small class="form-text text-muted">Provide a detailed description of how you plan to use the
                            loan funds</small>
                    </div>

                    <!-- Loan Information -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-info-circle me-2 text-primary"></i>Loan Information
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Interest Rate</small>
                                    <p class="mb-2"><strong>8.5% APR</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Repayment Period</small>
                                    <p class="mb-2"><strong>24 months</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Processing Time</small>
                                    <p class="mb-2"><strong>1-2 business days</strong></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Late Payment Fee</small>
                                    <p class="mb-0"><strong><?= $currency ?>25.00</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <a href="loan.php" class="btn btn-lg btn-outline-danger w-100">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-lg btn-primary w-100" name="loan-submit">
                                <i class="fas fa-arrow-right me-2"></i> Continue
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .settings-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        border: 1px solid #eaeaea;
    }

    .settings-section h3 {
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f8f9fa;
        font-weight: 700;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
        font-weight: 600;
    }

    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card.bg-light {
        border-left: 4px solid #007bff;
    }

    @media (max-width: 768px) {
        .settings-section {
            padding: 1rem;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Format amount input
        const amountInput = document.querySelector('input[name="amount"]');
        amountInput.addEventListener('input', function() {
            // Remove any non-numeric characters except decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');

            // Ensure only two decimal places
            if (this.value.includes('.')) {
                const parts = this.value.split('.');
                if (parts[1].length > 2) {
                    this.value = parts[0] + '.' + parts[1].substring(0, 2);
                }
            }
        });

        // Add real-time amount validation
        amountInput.addEventListener('blur', function() {
            const maxAmount = <?= $page['loanlimit'] ?>;
            const value = parseFloat(this.value);

            if (value > maxAmount) {
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent =
                    'Amount exceeds maximum loan limit of <?= $currency ?>' + maxAmount.toLocaleString();
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
</script>

<?php include 'layout/footer.php'; ?>