<?php
require_once __DIR__ . '/../config.php';
$current_page = 'loan';
$page_title = 'Loan Application Preview';
include 'layout/header.php';

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
require_once(ROOT_PATH . "/include/Transfer/Function.php");

// Check if user should be here
if (!isset($_SESSION['is_dom_transfer'])) {
    header("Location: ./dashboard.php");
    exit();
}

// Set session variables for loan process
$_SESSION['is_dom_code'] = "None";
$_SESSION['is_dom_transfer'] = "Loan";
$_SESSION['is_transfer'] = "None";

// TEMP TRANSACTION FETCH
$sql = "SELECT * FROM temp_trans WHERE user_id = :user_id AND trans_type='Loan' ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$temp_trans = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$temp_trans) {
    header("Location: ./loan-request.php");
    exit();
}

$amount = $temp_trans['amount'];
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Loan Application Preview</h2>
    <a href="<?= $web_url ?>/user/loan-request.php" class="btn btn-outline-primary">
        <i class="fas fa-edit me-2"></i> Edit Application
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="preview-icon bg-primary mb-3 mx-auto">
                        <i class="fas fa-file-invoice-dollar fa-2x text-white"></i>
                    </div>
                    <h3 class="preview-title">Review Your Loan Application</h3>
                    <p class="text-muted">Please verify all details before submitting your application</p>
                </div>

                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-receipt me-2 text-primary"></i>Application Details
                        </h5>

                        <div class="preview-details">
                            <div class="preview-item">
                                <span class="preview-label">Application Type</span>
                                <span class="preview-value">Loan Application</span>
                            </div>
                            <div class="preview-item">
                                <span class="preview-label">Loan Amount</span>
                                <span
                                    class="preview-value amount"><?= $currency ?><?= number_format($amount, 2, '.', ',') ?></span>
                            </div>
                            <div class="preview-item">
                                <span class="preview-label">Loan Purpose</span>
                                <span class="preview-value"><?= htmlspecialchars($temp_trans['account_name']) ?></span>
                            </div>
                            <div class="preview-item">
                                <span class="preview-label">Reference ID</span>
                                <span class="preview-value ref-id">#<?= $temp_trans['refrence_id'] ?></span>
                            </div>
                            <div class="preview-item">
                                <span class="preview-label">Application Date</span>
                                <span class="preview-value"><?= date('F j, Y g:i A') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-file-contract me-2 text-primary"></i>Loan Terms
                        </h5>

                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="term-item">
                                    <div class="term-value text-primary">8.5%</div>
                                    <div class="term-label">Interest Rate</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="term-item">
                                    <div class="term-value text-primary">24</div>
                                    <div class="term-label">Months Term</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="term-item">
                                    <div class="term-value text-primary">
                                        <?= $currency ?><?= number_format($amount * 0.0425, 2) ?>
                                    </div>
                                    <div class="term-label">Monthly Payment</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="term-item">
                                    <div class="term-value text-primary">
                                        <?= $currency ?><?= number_format($amount * 1.085, 2) ?>
                                    </div>
                                    <div class="term-label">Total Repayment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="alert-heading">Important Notice</h6>
                            <p class="mb-0">Your loan application will be reviewed and may take 1-2 business days to
                                process. You
                                will be notified once a decision has been made.</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-6">
                        <a href="<?= $web_url ?>/user/loan-request.php" class="btn btn-lg btn-outline-danger w-100">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                    <div class="col-6">
                        <!-- WORKING FORM: Direct action to loan-pin.php -->
                        <form method="POST" action="loan-pin.php" id="loanPreviewForm">
                            <input type="hidden" name="amount" value="<?= $temp_trans['amount'] ?>">
                            <input type="hidden" name="account_name"
                                value="<?= htmlspecialchars($temp_trans['account_name']) ?>">
                            <input type="hidden" name="user_id" value="<?= $temp_trans['user_id'] ?>">

                            <button type="submit" class="btn btn-lg btn-primary w-100" name="loan-preview"
                                id="confirmButton">
                                <i class="fas fa-lock me-2"></i> Confirm & Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .preview-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
    }

    .preview-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .preview-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .preview-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .preview-item:last-child {
        border-bottom: none;
    }

    .preview-label {
        font-weight: 600;
        color: #6c757d;
        min-width: 120px;
    }

    .preview-value {
        text-align: right;
        color: #2c3e50;
        font-weight: 500;
    }

    .preview-value.amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
    }

    .preview-value.ref-id {
        font-family: 'Courier New', monospace;
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .term-item {
        padding: 1rem 0.5rem;
    }

    .term-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .term-label {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .alert {
        border-radius: 8px;
        border: none;
    }

    .alert-info {
        background-color: #e7f3ff;
        color: #055160;
    }

    /* Loading state */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-right-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .preview-item {
            flex-direction: column;
            gap: 0.25rem;
        }

        .preview-label,
        .preview-value {
            text-align: left;
            width: 100%;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .term-item {
            padding: 0.75rem 0.25rem;
        }

        .term-value {
            font-size: 1.25rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmButton = document.getElementById('confirmButton');
        const loanPreviewForm = document.getElementById('loanPreviewForm');

        // Handle form submission with loading state
        loanPreviewForm.addEventListener('submit', function(e) {
            // Only show loading state if this is a valid form submission
            if (confirmButton && !confirmButton.disabled) {
                confirmButton.disabled = true;
                confirmButton.classList.add('btn-loading');
                confirmButton.innerHTML = 'Processing...';
            }
        });
    });
</script>

<?php include 'layout/footer.php'; ?>