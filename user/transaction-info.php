<?php
require_once __DIR__ . '/../config.php';
$current_page = 'transactions';
$page_title = 'Transaction Info';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

$trans_id = $_GET['id'];

$sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE transactions.trans_id=:trans_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['trans_id' => $trans_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$transStatus = TranStatus($result);

$amount = $result['amount'];
$transactiontype = $result['trans_type'];
$WireFee = $page['wirefee'];
$DomesticFee = $page['domesticfee'];

// Determine icon and color based on transaction type
$category_key = strtolower($result['trans_type']);
$color = 'primary'; // default
$icon = 'fa-receipt'; // default icon

if (strpos($category_key, 'salary') !== false || strpos($category_key, 'deposit') !== false) {
    $color = 'success';
    $icon = 'fa-money-check';
} elseif (strpos($category_key, 'transfer') !== false || strpos($category_key, 'send') !== false) {
    $color = 'danger';
    $icon = 'fa-paper-plane';
} elseif (strpos($category_key, 'loan') !== false) {
    $color = 'warning';
    $icon = 'fa-hand-holding-usd';
} elseif (strpos($category_key, 'bill') !== false) {
    $color = 'info';
    $icon = 'fa-mobile-alt';
} elseif (strpos($category_key, 'withdraw') !== false) {
    $color = 'danger';
    $icon = 'fa-money-bill-wave';
} elseif (strpos($category_key, 'payment') !== false) {
    $color = 'info';
    $icon = 'fa-credit-card';
} elseif (strpos($category_key, 'refund') !== false) {
    $color = 'success';
    $icon = 'fa-undo';
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Transaction Details</h2>
    <button class="btn btn-primary" id="printButton"><i class="fas fa-print me-2"></i>Print Receipt</button>
</div>

<!-- Print-only section -->
<div class="print-only mb-4">
    <div class="text-center">
        <img style="max-width: 200px; margin-bottom: 1rem;"
            src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>">
        <h4>Transaction Receipt</h4>
        <p>Account No: <?= $row['acct_no'] ?><br>Account Name: <?= $fullName ?></p>
        <small><i>Generated on <?php echo date('l, F j, Y \a\t g:i A'); ?></i></small>
    </div>
    <hr>
</div>

<div class="card transaction-detail-card">
    <div class="card-body text-center p-4">
        <!-- Transaction Icon -->
        <div class="transaction-icon-large bg-<?= $color ?>-light mx-auto mb-3">
            <i class="fas <?= $icon ?> text-<?= $color ?> fa-2x"></i>
        </div>

        <!-- Transaction Status -->
        <h3 class="mb-3"><?= $transStatus ?></h3>

        <!-- Amount -->
        <div class="amount-large text-<?= $result['transaction_type'] === 'credit' ? 'success' : 'danger' ?> mb-3">
            <?= $result['transaction_type'] === 'credit' ? '+' : '-' ?><?= $currency ?><?= number_format($amount, 2) ?>
        </div>

        <!-- Transaction Type -->
        <p class="text-muted mb-4 fs-5"><?= $result['trans_type'] ?></p>
    </div>

    <div class="card-body border-top">
        <?php if ($transactiontype == 'Domestic transfer'): ?>
            <div class="detail-item">
                <span class="detail-label">To</span>
                <span class="detail-value"><?= $result['account_name'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Bank Name</span>
                <span class="detail-value"><?= $result['bank_name'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Number</span>
                <span class="detail-value"><?= $result['account_number'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Fee</span>
                <span class="detail-value text-danger">-<?= $currency ?><?= number_format($DomesticFee, 2) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Type</span>
                <span class="detail-value"><?= $result['account_type'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Bank Country</span>
                <span class="detail-value"><?= $result['bank_country'] ?></span>
            </div>

        <?php elseif ($transactiontype == 'Wire transfer'): ?>
            <div class="detail-item">
                <span class="detail-label">To</span>
                <span class="detail-value"><?= $result['account_name'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Bank Name</span>
                <span class="detail-value"><?= $result['bank_name'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Number</span>
                <span class="detail-value"><?= $result['account_number'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Fee</span>
                <span class="detail-value text-danger">-<?= $currency ?><?= number_format($WireFee, 2) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Routine Number</span>
                <span class="detail-value"><?= $result['routine_number'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Type</span>
                <span class="detail-value"><?= $result['account_type'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Swift Code</span>
                <span class="detail-value"><?= $result['swift_code'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Bank Country</span>
                <span class="detail-value"><?= $result['bank_country'] ?></span>
            </div>

        <?php elseif ($transactiontype == 'Interbank transfer'): ?>
            <div class="detail-item">
                <span class="detail-label">To</span>
                <span class="detail-value"><?= $result['account_name'] ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Number</span>
                <span class="detail-value"><?= $result['account_number'] ?></span>
            </div>

        <?php else: ?>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value"><?= $result['trans_status'] ?></span>
            </div>
        <?php endif; ?>

        <!-- Common Fields for All Transaction Types -->
        <div class="detail-item">
            <span class="detail-label">Reference ID</span>
            <span class="detail-value">#<?= $result['refrence_id'] ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Transaction Flow</span>
            <span class="detail-value">
                <span class="badge bg-<?= $result['transaction_type'] === 'credit' ? 'success' : 'danger' ?>">
                    <?= ucfirst($result['transaction_type']) ?>
                </span>
            </span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Date & Time</span>
            <span class="detail-value"><?= date('F j, Y g:i A', strtotime($result['created_at'])) ?></span>
        </div>

        <?php if (!empty($result['description'])): ?>
            <div class="detail-item">
                <span class="detail-label">Description</span>
                <span class="detail-value"><?= htmlspecialchars($result['description']) ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Hide the logo on screen */
    .print-only {
        display: none;
    }

    /* Show the logo only in print */
    @media print {
        .print-only {
            display: block;
        }

        .form-head {
            display: none;
        }

        .transaction-detail-card {
            border: none !important;
            box-shadow: none !important;
        }
    }

    .transaction-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eaeaea;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .detail-value {
        font-weight: 500;
        color: #2c3e50;
        text-align: right;
    }

    .amount-large {
        font-size: 2rem;
        font-weight: 700;
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

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .bg-primary-light {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('printButton').addEventListener('click', function() {
            // Create a container with only the content we want to print
            var printContent = document.createElement('div');
            printContent.innerHTML = document.querySelector('.print-only').outerHTML;
            printContent.innerHTML += document.querySelector('.transaction-detail-card').outerHTML;

            // Open a new window for printing
            var printWindow = window.open('', '_blank', 'width=800,height=600');

            printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Transaction Receipt - <?= $fullName ?></title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            margin: 20px;
                            background: white;
                        }
                        .print-only {
                            display: block !important;
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .transaction-detail-card {
                            border: 1px solid #dee2e6;
                            border-radius: 8px;
                            overflow: hidden;
                        }
                        .transaction-icon-large {
                            width: 80px;
                            height: 80px;
                            border-radius: 16px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto 1.5rem;
                        }
                        .amount-large {
                            font-size: 2rem;
                            font-weight: 700;
                            margin: 1rem 0;
                        }
                        .detail-item {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 1rem 0;
                            border-bottom: 1px solid #eaeaea;
                        }
                        .detail-item:last-child {
                            border-bottom: none;
                        }
                        .detail-label {
                            font-weight: 600;
                            color: #6c757d;
                            font-size: 0.9rem;
                        }
                        .detail-value {
                            font-weight: 500;
                            color: #2c3e50;
                            text-align: right;
                        }
                        .bg-success-light {
                            background-color: rgba(40, 167, 69, 0.1) !important;
                        }
                        .bg-danger-light {
                            background-color: rgba(220, 53, 69, 0.1) !important;
                        }
                        .bg-primary-light {
                            background-color: rgba(0, 123, 255, 0.1) !important;
                        }
                        .bg-warning-light {
                            background-color: rgba(255, 193, 7, 0.1) !important;
                        }
                        .bg-info-light {
                            background-color: rgba(23, 162, 184, 0.1) !important;
                        }
                        .text-success {
                            color: #28a745 !important;
                        }
                        .text-danger {
                            color: #dc3545 !important;
                        }
                        .text-primary {
                            color: #007bff !important;
                        }
                        .text-warning {
                            color: #ffc107 !important;
                        }
                        .text-info {
                            color: #17a2b8 !important;
                        }
                        @media print { 
                            body { margin: 0; }
                            .page-break { page-break-after: always; }
                        }
                    </style>
                </head>
                <body>
                    ${printContent.innerHTML}
                </body>
            </html>
        `);

            printWindow.document.close();

            // Wait for content to load then print
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        });
    });
</script>

<?php include 'layout/footer.php'; ?>