<?php
$current_page = 'transfer';
$page_title = 'Transfer Summary';
include 'layout/header.php';

// In a real application, these values would come from the form submission or session
$from_account = isset($_POST['from_account']) ? $_POST['from_account'] : 'checking';
$to_account = isset($_POST['to_account']) ? $_POST['to_account'] : 'external';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '$100.00';
$description = isset($_POST['description']) ? $_POST['description'] : 'Monthly transfer';
?>

<div class="page-header">
    <h1 class="page-title">Transfer Summary</h1>
</div>

<div class="form-container">
    <h3 style="margin-bottom: 1.5rem;">Review Your Transfer</h3>

    <div class="transaction-detail">
        <div class="detail-item">
            <span class="detail-label">From Account</span>
            <span class="detail-value">
                <?php
                if ($from_account === 'checking') {
                    echo 'Checking Account (**** 4567)';
                } else {
                    echo 'Savings Account (**** 8912)';
                }
                ?>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">To Account</span>
            <span class="detail-value">
                <?php
                if ($to_account === 'external') {
                    echo 'External Bank Account';
                } elseif ($to_account === 'savings') {
                    echo 'My Savings Account';
                } else {
                    echo 'Friend';
                }
                ?>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Amount</span>
            <span class="detail-value" style="font-weight: 700; color: var(--dark);"><?php echo $amount; ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Description</span>
            <span class="detail-value"><?php echo $description ?: 'No description'; ?></span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Fee</span>
            <span class="detail-value">$0.00</span>
        </div>

        <div class="detail-item" style="border-top: 1px solid var(--gray-light); padding-top: 1rem;">
            <span class="detail-label" style="font-weight: 700;">Total</span>
            <span class="detail-value" style="font-weight: 700; color: var(--dark);"><?php echo $amount; ?></span>
        </div>
    </div>

    <div class="action-buttons" style="display: flex; gap: 1rem; margin-top: 2rem;">
        <a href="transfer.php" class="btn" style="background: var(--gray-light); color: var(--dark);">Cancel</a>
        <a href="pincode.php" class="btn btn-primary">Confirm Transfer</a>
    </div>
</div>

<?php include 'layout/footer.php'; ?>