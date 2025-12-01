<?php
require_once __DIR__ . '/../config.php';
$current_page = 'transfer-success';
$page_title = 'Transaction Successful';
include 'layout/header.php';

if (!isset($_SESSION['is_transfer'])) {
    header("Location:./dashboard.php");
    exit();
}

if (!isset($_SESSION['dom_transfer'])) {
    header("Location:./dashboard.php");
    exit();
}

// Clear sessions
unset($_SESSION['is_dom_transfer']);
unset($_SESSION['is_wire_transfer']);

// Fetch latest transaction
$sql = "SELECT * FROM transactions WHERE user_id =:user_id ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$transStatus = TranStatus($result);

$amount = $result['amount'];
$transactiontype = $result['trans_type'];
$WireFee = $page['wirefee'];
$DomesticFee = $page['domesticfee'];
$totalAmount = $amount + ($transactiontype == 'Wire transfer' ? $WireFee : $DomesticFee);
?>

<div class="form-head mb-4">
    <h2 class="text-black font-w600 mb-2">Transaction Status</h2>
    <p class="mb-0 text-muted">Your transfer has been processed successfully</p>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
        <div class="card border-0 shadow-sm mb-4" id="printableArea">
            <div class="card-body text-center py-5">
                <div class="success-icon mb-4">
                    <div class="avatar avatar-lg bg-success rounded-circle mx-auto">
                        <i class="fas fa-check text-white fa-2x"></i>
                    </div>
                </div>
                <h3 class="text-success mb-3">Transaction Successful!</h3>
                <p class="text-muted mb-4">Your <?= htmlspecialchars($transactiontype) ?> has been processed
                    successfully.</p>

            </div>

            <div class="card-body border-top">
                <h5 class="card-title mb-4">Transaction Details</h5>

                <div class="transaction-summary">
                    <?php if ($transactiontype == 'Domestic transfer'): ?>
                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exchange-alt text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transaction Type</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['trans_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Recipient</h6>
                                <p class="text-muted mb-0">Account holder name</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['account_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-landmark text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Bank Name</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['bank_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Number</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['account_number']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transfer Amount</h6>
                                <p class="text-muted mb-0">Principal amount</p>
                            </div>
                        </div>
                        <span
                            class="text-success fw-bold"><?= $currency ?><?= number_format($amount, 2, '.', ',') ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-receipt text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transfer Fee</h6>
                                <p class="text-muted mb-0">Service charge</p>
                            </div>
                        </div>
                        <span class="text-danger"><?= $currency ?><?= number_format($DomesticFee, 2, '.', ',') ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-briefcase text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Type</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['account_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-globe text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Bank Country</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['bank_country']) ?></span>
                    </div>

                    <?php elseif ($transactiontype == 'Wire transfer'): ?>
                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exchange-alt text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transaction Type</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['trans_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Recipient</h6>
                                <p class="text-muted mb-0">Account holder name</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['account_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-landmark text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Bank Name</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['bank_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Number</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['account_number']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transfer Amount</h6>
                                <p class="text-muted mb-0">Principal amount</p>
                            </div>
                        </div>
                        <span
                            class="text-success fw-bold"><?= $currency ?><?= number_format($amount, 2, '.', ',') ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-receipt text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transfer Fee</h6>
                                <p class="text-muted mb-0">International service charge</p>
                            </div>
                        </div>
                        <span class="text-danger"><?= $currency ?><?= number_format($WireFee, 2, '.', ',') ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-sort-numeric-up text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Routing Number</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['routine_number']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-briefcase text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Type</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['account_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-code text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">SWIFT Code</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['swift_code']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-globe text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Bank Country</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['bank_country']) ?></span>
                    </div>

                    <?php elseif ($transactiontype == 'Interbank transfer'): ?>
                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exchange-alt text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transaction Type</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['trans_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Recipient</h6>
                                <p class="text-muted mb-0">Account holder name</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['account_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Number</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['account_number']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transfer Amount</h6>
                                <p class="text-muted mb-0">Principal amount</p>
                            </div>
                        </div>
                        <span
                            class="text-success fw-bold"><?= $currency ?><?= number_format($amount, 2, '.', ',') ?></span>
                    </div>

                    <?php else: ?>
                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exchange-alt text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Transaction Type</h6>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($result['trans_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Amount</h6>
                                <p class="text-muted mb-0">Transaction amount</p>
                            </div>
                        </div>
                        <span
                            class="text-success fw-bold"><?= $currency ?><?= number_format($amount, 2, '.', ',') ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Status</h6>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['trans_status']) ?></span>
                    </div>

                    <?php endif; ?>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hashtag text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Reference ID</h6>
                                <p class="text-muted mb-0">Transaction identifier</p>
                            </div>
                        </div>
                        <span class="text-info">#<?= htmlspecialchars($result['refrence_id']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Date & Time</h6>
                                <p class="text-muted mb-0">Transaction timestamp</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($result['created_at']) ?></span>
                    </div>

                    <div class="summary-total bg-light rounded p-4 mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Total Amount</h5>
                            <h4 class="text-primary mb-0">
                                <?= $currency ?><?= number_format($totalAmount, 2, '.', ',') ?></h4>
                        </div>
                        <small class="text-muted">Including all fees and charges</small>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-transparent border-0">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="<?= $web_url ?>/user/transfer.php" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-redo me-2"></i>Send Again
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button onclick="printProfessionalReceipt()" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-print me-2"></i>Print Receipt
                        </button>
                    </div>
                    <div class="col-md-4">
                        <a href="<?= $web_url ?>/user/dashboard.php" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-success fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Transaction Secured</h6>
                        <p class="text-muted mb-0">Your transaction has been processed securely and all details have
                            been recorded. You will receive a confirmation email shortly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    border: 1px solid #eef2f7;
}

.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
}

.status-badge {
    font-weight: 600;
    font-size: 0.9rem;
}

.summary-item {
    transition: background-color 0.2s ease;
}

.summary-item:hover {
    background-color: #fafbfe;
    margin-left: -1rem;
    margin-right: -1rem;
    padding-left: 1rem !important;
    padding-right: 1rem !important;
    border-radius: 8px;
}

.summary-total {
    /* Assuming var(--primary) is defined elsewhere, keeping existing style */
    border: 2px solid var(--primary);
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

.btn-outline-primary:hover {
    background: var(--primary);
    color: white;
}

.btn-outline-success:hover {
    background: #28a745;
    color: white;
}

/* Removed the original @media print block to rely solely on the new JS/HTML method */

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

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.25rem;
    }

    .btn-lg {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .summary-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .summary-item span {
        align-self: flex-end;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }

    .form-head {
        text-align: center;
    }

    .card-footer .row {
        flex-direction: column;
        gap: 0.5rem;
    }

    .card-footer .col-md-4 {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animations
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');
    });

    // Prevent form resubmission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});

/**
 * Creates a professional, isolated print view in a new window.
 * This avoids inheriting styling from the main application template.
 */
function printProfessionalReceipt() {
    // 1. Collect all necessary PHP variables into a JS object/variables
    // Ensure you have access to these PHP variables in the scope where this script runs.
    const transDetails = {
        type: "<?= htmlspecialchars($transactiontype) ?>",
        status: "Successful",
        amount: "<?= $currency ?><?= number_format($amount, 2, '.', ',') ?>",
        fee: "<?= $currency ?><?= number_format(($transactiontype == 'Wire transfer' ? $WireFee : ($transactiontype == 'Domestic transfer' ? $DomesticFee : 0)), 2, '.', ',') ?>",
        totalAmount: "<?= $currency ?><?= number_format($totalAmount, 2, '.', ',') ?>",
        refId: "<?= htmlspecialchars($result['refrence_id']) ?>",
        timestamp: "<?= htmlspecialchars($result['created_at']) ?>",
        logoUrl: "<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>",
        accountName: "<?= htmlspecialchars($result['account_name'] ?? '') ?>",
        bankName: "<?= htmlspecialchars($result['bank_name'] ?? '') ?>",
        accountNumber: "<?= htmlspecialchars($result['account_number'] ?? '') ?>",
        accountType: "<?= htmlspecialchars($result['account_type'] ?? '') ?>",
        bankCountry: "<?= htmlspecialchars($result['bank_country'] ?? '') ?>",
        routingNumber: "<?= htmlspecialchars($result['routine_number'] ?? '') ?>",
        swiftCode: "<?= htmlspecialchars($result['swift_code'] ?? '') ?>",
    };

    // 2. Build the dynamic detail rows based on transaction type
    let detailRows = `
            <div class="detail-row"><span>Transaction Type:</span><span>${transDetails.type}</span></div>
            <div class="detail-row"><span>Status:</span><span class="status-success">SUCCESSFUL</span></div>
        `;

    // Recipient/Account details specific to transfers
    if (transDetails.type === 'Domestic transfer' || transDetails.type === 'Wire transfer' || transDetails.type ===
        'Interbank transfer') {
        detailRows += `
                <div class="detail-row"><span>Recipient Name:</span><span>${transDetails.accountName}</span></div>
                <div class="detail-row"><span>Account Number:</span><span>${transDetails.accountNumber}</span></div>
            `;
    }

    // Domestic/Wire specific bank details
    if (transDetails.type === 'Domestic transfer' || transDetails.type === 'Wire transfer') {
        detailRows += `
                <div class="detail-row"><span>Bank Name:</span><span>${transDetails.bankName}</span></div>
                <div class="detail-row"><span>Account Type:</span><span>${transDetails.accountType}</span></div>
                <div class="detail-row"><span>Bank Country:</span><span>${transDetails.bankCountry}</span></div>
            `;
    }

    // Wire-specific details
    if (transDetails.type === 'Wire transfer') {
        detailRows += `
                <div class="detail-row"><span>Routing Number:</span><span>${transDetails.routingNumber}</span></div>
                <div class="detail-row"><span>SWIFT Code:</span><span>${transDetails.swiftCode}</span></div>
            `;
    }

    // Amount and Fees
    if (transDetails.type === 'Domestic transfer' || transDetails.type === 'Wire transfer') {
        detailRows += `
                <div class="detail-row"><span>Transfer Amount:</span><span class="amount-val">${transDetails.amount}</span></div>
                <div class="detail-row"><span>Transfer Fee:</span><span class="fee-val">${transDetails.fee}</span></div>
            `;
    } else {
        detailRows += `
                <div class="detail-row"><span>Transaction Amount:</span><span class="amount-val">${transDetails.amount}</span></div>
            `;
    }


    // Common fields
    detailRows += `
            <hr style="margin: 15px 0;">
            <div class="detail-row"><span>Reference ID:</span><span class="ref-id">#${transDetails.refId}</span></div>
            <div class="detail-row"><span>Transaction Time:</span><span>${transDetails.timestamp}</span></div>
        `;

    // 3. Construct the HTML for the new print window with embedded styles
    const printContent = `
            <html>
            <head>
                <title>Transaction Receipt - #${transDetails.refId}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 30px;
                        font-size: 11pt;
                        color: #333;
                    }
                    .receipt-container {
                        max-width: 700px;
                        margin: 0 auto;
                        border: 1px solid #ccc;
                        padding: 25px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    .header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding-bottom: 20px;
                        border-bottom: 2px solid #eee;
                        margin-bottom: 20px;
                    }
                    .logo img {
                        max-height: 50px;
                        width: auto;
                    }
                    .info h1 {
                        margin: 0;
                        font-size: 1.5em;
                        color: #007bff;
                    }
                    .info p {
                        margin: 5px 0 0 0;
                        font-size: 0.9em;
                        text-align: right;
                    }
                    h2 {
                        color: #007bff;
                        border-bottom: 1px solid #007bff;
                        padding-bottom: 5px;
                        margin-top: 20px;
                        margin-bottom: 15px;
                        font-size: 1.2em;
                    }
                    .detail-row {
                        display: flex;
                        justify-content: space-between;
                        padding: 8px 0;
                        border-bottom: 1px dashed #eee;
                    }
                    .detail-row span:first-child {
                        font-weight: 600;
                    }
                    .total-row {
                        display: flex;
                        justify-content: space-between;
                        padding: 15px 0;
                        border-top: 2px solid #007bff;
                        margin-top: 15px;
                        font-size: 1.2em;
                        font-weight: bold;
                    }
                    .status-success {
                        color: #28a745;
                        font-weight: bold;
                    }
                    .ref-id {
                        color: #17a2b8;
                        font-weight: bold;
                    }
                    .amount-val {
                        color: #28a745;
                        font-weight: bold;
                    }
                    .fee-val {
                        color: #dc3545;
                    }
                    .footer-note {
                        margin-top: 30px;
                        border-top: 1px solid #ccc;
                        padding-top: 15px;
                        text-align: center;
                        font-size: 0.8em;
                        color: #666;
                    }
                    @media print {
                        .receipt-container {
                            border: none;
                            box-shadow: none;
                            padding: 0;
                        }
                        body {
                            padding: 0;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="receipt-container">
                    <div class="header">
                        <div class="logo">
                            <img src="${transDetails.logoUrl}" alt="Wallet System Logo">
                        </div>
                        <div class="info">
                            <h1>Transaction Receipt</h1>
                            <p>Printed: ${new Date().toLocaleString()}</p>
                        </div>
                    </div>

                    <h2>Transaction Summary</h2>
                    ${detailRows}

                    <div class="total-row">
                        <span>TOTAL CHARGED</span>
                        <span style="color: #007bff;">${transDetails.totalAmount}</span>
                    </div>

                    <div class="footer-note">
                        This receipt is automatically generated on <?= $web_title ?>. <br>
                        For customer support, please reference ID #${transDetails.refId}.
                    </div>
                </div>
            </body>
            </html>
        `;

    // 4. Open a new window and write the content
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    printWindow.document.write(printContent);
    printWindow.document.close();

    // 5. Trigger the print dialog after the content is loaded
    printWindow.onload = function() {
        printWindow.print();
    };
}

// Add CSS animations (keeping this part as it was originally for the main page view)
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