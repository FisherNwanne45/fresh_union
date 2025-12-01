<?php
require_once __DIR__ . '/../config.php';
$current_page = 'transactions';
$page_title = 'Transaction History';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

// Define the start and end dates for the past month (last 30 days) - Used for screen stats
$start_date_30 = date('Y-m-d 00:00:00', strtotime('-30 days'));
$end_date_30 = date('Y-m-d 23:59:59');

// Define the start date for the past 6 months (180 days) - Used for print stats
$start_date_180 = date('Y-m-d 00:00:00', strtotime('-180 days'));
$end_date_180 = date('Y-m-d 23:59:59');

// --- 30 DAY CALCULATIONS (FOR SCREEN DISPLAY) ---
// Inflow (credits) - 30 Days
$sql_30_in = "SELECT SUM(amount) 
        FROM transactions 
        WHERE user_id = :id 
          AND transaction_type = 'credit' 
          AND trans_status = 'completed'
          AND created_at >= :start
          AND created_at <= :end";
$stmt = $conn->prepare($sql_30_in);
$stmt->execute([
    'id' => $user_id,
    'start' => $start_date_30,
    'end' => $end_date_30
]);
$total = $stmt->fetch(PDO::FETCH_NUM);
$inflow = $total[0] ?? 0;

// Outflow (debits) - 30 Days
$sql_30_out = "SELECT SUM(amount) 
        FROM transactions 
        WHERE user_id = :id 
          AND transaction_type = 'debit' 
          AND trans_status = 'completed'
          AND created_at >= :start
          AND created_at <= :end";
$stmt = $conn->prepare($sql_30_out);
$stmt->execute([
    'id' => $user_id,
    'start' => $start_date_30,
    'end' => $end_date_30
]);
$total = $stmt->fetch(PDO::FETCH_NUM);
$outflow = $total[0] ?? 0;


// --- 180 DAY CALCULATIONS (FOR PRINT DISPLAY) ---
// Inflow (credits) - 180 Days
$sql_180_in = "SELECT SUM(amount) 
        FROM transactions 
        WHERE user_id = :id 
          AND transaction_type = 'credit' 
          AND trans_status = 'completed'
          AND created_at >= :start
          AND created_at <= :end";
$stmt = $conn->prepare($sql_180_in);
$stmt->execute([
    'id' => $user_id,
    'start' => $start_date_180,
    'end' => $end_date_180
]);
$total_180 = $stmt->fetch(PDO::FETCH_NUM);
$inflow_180 = $total_180[0] ?? 0;

// Outflow (debits) - 180 Days
$sql_180_out = "SELECT SUM(amount) 
        FROM transactions 
        WHERE user_id = :id 
          AND transaction_type = 'debit' 
          AND trans_status = 'completed'
          AND created_at >= :start
          AND created_at <= :end";
$stmt = $conn->prepare($sql_180_out);
$stmt->execute([
    'id' => $user_id,
    'start' => $start_date_180,
    'end' => $end_date_180
]);
$total_180 = $stmt->fetch(PDO::FETCH_NUM);
$outflow_180 = $total_180[0] ?? 0;


// Fetch all transactions
$sql2 = "SELECT * FROM transactions WHERE user_id =:user_id ORDER BY trans_id DESC";
$wire = $conn->prepare($sql2);
$wire->execute(['user_id' => $user_id]);
$transactions = $wire->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center screen-only">
    <h2 class="text-black font-w600 mb-0">Transaction History</h2>
    <button class="btn btn-primary" id="printButton"><i class="fas fa-print me-2"></i>Print Statement</button>
</div>

<div class="print-only mb-4">
    <div class="text-center">
        <img style="max-width: 200px; margin-bottom: 1rem;"
            src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>">
        <h4>Account Statement</h4>
        <p>
            Account No: <?= $row['acct_no'] ?><br>
            Account Name: <?= $fullName ?><br>
            Current Balance: <?= $currency ?><?= number_format($row['acct_balance'], 2) ?>
        </p>
        <small><i>This Statement was generated on <?= date('l, F j, Y \a\t g:i A'); ?></i></small>
    </div>
    <hr>

    <div class="row mb-4">
        <div class="col-6">
            <h6 class="text-success">Total Inflow (Last 6 Months):
                +<?= $currency ?><?= number_format($inflow_180, 2, '.', ','); ?></h6>
        </div>
        <div class="col-6 text-end">
            <h6 class="text-danger">Total Outflow (Last 6 Months):
                -<?= $currency ?><?= number_format($outflow_180, 2, '.', ','); ?></h6>
        </div>
    </div>

    <h5 style="margin-top: 1.5rem; margin-bottom: 1rem;"> Statement of Account Activities</h5>
    <table class="table table-bordered print-transaction-table" style="font-size: 10pt;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="width: 15%;">Date</th>
                <th style="width: 25%;"> Name</th>
                <th style="width: 35%;">Description</th>
                <th style="width: 15%; text-align: right;">Amount</th>
                <th style="width: 15%; text-align: right;">Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 1. Filter and prepare data for print (only 'completed' status)
            $completed_transactions = array_filter($transactions, function ($t) {
                return $t['trans_status'] === 'completed';
            });

            $current_balance = $row['acct_balance'];
            $initial_balance = $current_balance;

            // 2. Calculate initial balance before *completed* transactions
            foreach (array_reverse($completed_transactions) as $result) {
                if ($result['transaction_type'] === 'credit') {
                    $initial_balance -= $result['amount'];
                } else {
                    $initial_balance += $result['amount'];
                }
            }

            // 3. Loop through ONLY COMPLETED transactions to build the print table
            $running_balance = $initial_balance;
            foreach ($completed_transactions as $result):
                $amount_display = ($result['transaction_type'] === 'credit' ? '+' : '-') . $currency . number_format($result['amount'], 2);

                // Calculate Running Balance
                if ($result['transaction_type'] === 'credit') {
                    $running_balance += $result['amount'];
                } else {
                    $running_balance -= $result['amount'];
                }


                $name_logic = '';

                if (!empty($result['account_name'])) {
                    $name_logic .= ' ' . htmlspecialchars($result['account_name']);
                } else {
                    $name_logic .= ' ' . htmlspecialchars($web_title);
                }



                // Description logic for print table
                $print_description = '';
                if (!empty($result['description'])) {
                    $print_description .= '  ' . htmlspecialchars($result['description']);
                } elseif (!empty($result['trans_type'])) {
                    $print_description .= '  ' . htmlspecialchars($result['trans_type']);
                }
            ?>
            <tr>
                <td><?= date('Y-m-d', strtotime($result['created_at'])) ?></td>
                <td><?= $name_logic ?></td>
                <td><?= $print_description ?></td>
                <td style="text-align: right;"><?= $amount_display ?></td>
                <td style="text-align: right;"><?= $currency ?><?= number_format($running_balance, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 5rem; text-align: right;">
        <img src="layout/sign.png"
            style="max-width: 150px; border-bottom: 1px solid #000; display: inline-block; margin-bottom: 5px;">
        <p style="margin: 0; font-size: 11pt; font-weight: bold;">Signed, Management</p>
        <p style="margin: 0; font-size: 10pt; color: #555;"><?= $web_title ?></p>
    </div>

</div>
<div class="row mb-4 stats-row screen-only">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="feature-icon bg-success-light rounded-circle me-3">
                        <i class="fas fa-arrow-down text-success"></i>
                    </div>
                    <div class="text-start">
                        <p class="fs-14 mb-1">Total Inflow <small class="text-muted">(Last 30 Days)</small></p>
                        <span class="fs-24 text-black font-w600 text-success">
                            +<?= $currency ?><?= number_format($inflow, 2, '.', ','); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="feature-icon bg-danger-light rounded-circle me-3">
                        <i class="fas fa-arrow-up text-danger"></i>
                    </div>
                    <div class="text-start">
                        <p class="fs-14 mb-1">Total Outflow <small class="text-muted">(Last 30 days)</small></p>
                        <span class="fs-24 text-black font-w600 text-danger">
                            -<?= $currency ?><?= number_format($outflow, 2, '.', ','); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card screen-only">
    <div class="card-header">
        <h4 class="card-title">All Transactions</h4>
    </div>
    <div class="card-body p-0">

        <?php if (empty($transactions)): ?>
        <div class="text-center py-5">
            <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
            <h4>No Transactions Yet</h4>
            <p class="text-muted">Your transaction history will appear here</p>
        </div>

        <?php else: ?>
        <div class="transaction-list">

            <?php foreach ($transactions as $result):
                    $amount = $result['amount'];
                    $category_key = strtolower($result['trans_type']);

                    // icon logic
                    $color = 'primary';
                    $icon = 'fa-receipt';

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
                        $icon = 'fa-mobile-alt';
                    }

                    // NEW LOGIC: amount color based on status
                    $amountColor = ($result['transaction_type'] === 'credit') ? 'success' : 'danger';

                    if ($result['trans_status'] === 'processing') {
                        $amountColor = 'warning';
                    } elseif ($result['trans_status'] === 'failed') {
                        $amountColor = 'danger';
                    }
                ?>

            <a href="./transaction-info.php?id=<?= $result['trans_id']; ?>" class="transaction-item">
                <div class="transaction-info">
                    <div class="transaction-icon bg-<?= $color ?>-light">
                        <i class="fas <?= $icon ?> text-<?= $color ?>"></i>
                    </div>
                    <div class="transaction-details">
                        <h6 class="mb-1"><?= htmlspecialchars($result['trans_type']) ?></h6>
                        <span class="text-muted"><?= date('F j, Y', strtotime($result['created_at'])) ?></span>
                    </div>
                </div>

                <div class="transaction-mid d-none d-md-block">
                    <?php if (!empty($result['description'])): ?>
                    <h6 class="mb-1 text-center"><?= htmlspecialchars($result['description']) ?></h6>
                    <?php endif; ?>

                    <?php if (!empty($result['account_name'])): ?>
                    <h6 class="mb-1 text-center"><?= htmlspecialchars($result['account_name']) ?></h6>
                    <?php endif; ?>

                    <?php if (!empty($result['trans_status'])): ?>
                    <?php
                                $status = strtolower($result['trans_status']);

                                // Convert "processing" → "pending"
                                if ($status === 'processing') {
                                    $status = 'pending';
                                }

                                // Capitalize first letter
                                $displayStatus = ucfirst($status);

                                // Color class
                                $colorClass = 'text-muted';

                                if ($status === 'completed') {
                                    $colorClass = 'text-success';
                                } elseif ($status === 'pending') {
                                    $colorClass = 'text-warning';
                                } elseif ($status === 'failed') {
                                    $colorClass = 'text-danger';
                                }
                                ?>

                    <span class="<?= $colorClass ?> d-block text-center"><?= $displayStatus ?></span>

                    <?php endif; ?>
                </div>

                <div class="transaction-amount">
                    <span class="amount text-<?= $amountColor ?>">
                        <?= $result['transaction_type'] === 'credit' ? '+' : '-' ?>
                        <?= $currency ?><?= number_format($amount, 2) ?>
                    </span>
                </div>
            </a>

            <?php endforeach; ?>

        </div>
        <?php endif; ?>

    </div>
</div>
<style>
.print-only {
    display: none;
    /* Default: hidden on screen */
}

/* 2. Centering the `transaction-mid` column using flexbox */
.transaction-item {
    display: flex;
    align-items: center;
    /* Updated: use space-between to push outer columns to the edges */
    justify-content: space-between;
    padding: 1rem 1.25rem;
    text-decoration: none;
    color: inherit;
    transition: all .3s ease;
    border-bottom: 1px solid #f0f0f0;
}

.transaction-info {
    display: flex;
    align-items: center;
    /* Give the left column a fixed flex basis to define its space */
    flex: 0 0 35%;
}

.transaction-mid {
    /* Give the middle column a fixed flex basis and center its content */
    flex: 0 0 30%;
    margin-left: 0;
    /* Remove existing margin to allow centering */
    text-align: center;
    /* Center the text content within the div */
}

.transaction-amount {
    /* Give the right column a fixed flex basis and align its content right */
    flex: 0 0 20%;
    text-align: right;
}

/* End Centering fix */


/* 3. Print-specific styles (Original plus new print table visibility) */
@media print {
    .screen-only {
        display: none !important;
        /* Hide screen elements */
    }

    .print-only {
        display: block !important;
        /* Show print elements */
    }

    .form-head,
    .stats-row {
        display: none;
    }

    .transaction-list {
        border: none !important;
        box-shadow: none !important;
    }
}

/* ... (rest of your original CSS) ... */

.feature-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
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

.transaction-list {
    display: flex;
    flex-direction: column;
    gap: 1px;
}

.transaction-item:hover {
    background-color: #f8f9fa;
    text-decoration: none;
    color: inherit;
}

.transaction-item:last-child {
    border-bottom: none;
}

.transaction-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 16px;
}

.transaction-details h6 {
    margin-bottom: 3px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 15px;
}

.transaction-details span {
    font-size: 13px;
}

.transaction-amount .amount {
    font-weight: 700;
    font-size: 15px;
}

.transaction-mid h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #495057;
}

.transaction-mid span {
    font-size: 12px;
}

@media (max-width:992px) {

    /* Adjust flex-basis for smaller screens (like laptops/tablets) to prevent wrap */
    .transaction-info {
        flex: 0 0 40%;
    }

    .transaction-mid {
        flex: 0 0 25%;
    }

    .transaction-amount {
        flex: 0 0 20%;
    }
}

@media (max-width:768px) {

    /* Original logic: hide transaction-mid on smaller screens */
    .transaction-mid {
        display: none !important;
    }

    .transaction-info {
        flex: 1;
        /* Take up all available space on left */
    }

    .transaction-amount {
        flex: initial;
        /* Let the amount column size naturally */
    }
}

@media (max-width:576px) {
    .transaction-item {
        padding: .75rem 1rem;
    }

    .transaction-icon {
        width: 40px;
        height: 40px;
        margin-right: .75rem;
    }

    .transaction-details h6 {
        font-size: 14px;
    }

    .transaction-details span {
        font-size: 12px;
    }

    .transaction-amount .amount {
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('printButton').addEventListener('click', function() {
        // Open a new print window
        var printWindow = window.open('', '_blank', 'width=800,height=600');

        // Get the content of the print-only div
        var printContentHTML = document.querySelector('.print-only').innerHTML;

        // Write to the new window
        printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Transaction History - <?= $fullName ?></title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; background: white; }
                        .print-only { display: block; text-align: left; margin-bottom: 20px; }
                        .print-transaction-table th, .print-transaction-table td {
                            padding: 8px;
                        }
                        .text-success { color: #28a745 !important; }
                        .text-danger { color: #dc3545 !important; }
                        .text-warning { color: #ffc107 !important; }
                        h4, p { margin-bottom: 0.5rem; }
                        /* Ensure no borders/shadows from screen styles */
                        .card { box-shadow: none !important; border: none !important; }
                    </style>
                </head>
                <body>
                    <div class="print-only">${printContentHTML}</div>
                </body>
                </html>
            `);

        printWindow.document.close();
        // Wait for content to load, then print
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    });
});
</script>

<?php include 'layout/footer.php'; ?>