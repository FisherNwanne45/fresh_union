<?php
require_once __DIR__ . '/../config.php';
$current_page = 'loan';
$page_title = 'My Loan';
include 'layout/header.php';

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">My Loan</h2>
    <a href="loan-request.php" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Apply for Loan
    </a>
</div>

<!-- Loan Summary Cards -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 me-2">Current Loan Balance</h4>
                    <div class="card-icon bg-warning">
                        <i class="fas fa-hand-holding-usd text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-value"><?= $currency ?><?php echo number_format($loan_balance, 2, '.', ','); ?></div>
                <div class="card-change text-muted">Total Outstanding</div>
                <div class="mt-3">
                    <div class="progress-bar">
                        <div class="progress" style="width: 75%;"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Paid:
                            <?= $currency ?><?php echo number_format($loan_balance * 0.25, 2, '.', ','); ?></small>
                        <small class="text-muted">Total:
                            <?= $currency ?><?php echo number_format($loan_balance * 1.25, 2, '.', ','); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 me-2">Next Payment Due</h4>
                    <div class="card-icon bg-danger">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-value"><?= $currency ?><?php echo number_format($loan_balance * 0.05, 2, '.', ','); ?>
                </div>
                <div class="card-change text-muted">Due in few days</div>
                <div class="mt-3">
                    <div class="progress-bar">
                        <div class="progress bg-success" style="width: 15%;"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Current Cycle</small>
                        <small class="text-muted">Monthly</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Quick Actions</h4>
    </div>
    <div class="card-body p-0">
        <div class="setting-item" onclick="location.href='loan-request.php'">
            <div class="setting-info">
                <h6 class="mb-1">Apply for New Loan</h6>
                <p class="text-muted mb-0">Get approved for personal, auto, or home loans</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="setting-item" onclick="location.href='deposit.php'">
            <div class="setting-info">
                <h6 class="mb-1">Make Loan Payment</h6>
                <p class="text-muted mb-0">Pay your outstanding loan balance</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="setting-item" onclick="location.href='support.php'">
            <div class="setting-info">
                <h6 class="mb-1">Loan Support</h6>
                <p class="text-muted mb-0">Get help with your loan account</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>
</div>

<!-- Recent Loan Transactions -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Recent Loan Transactions</h4>
        <a href="transactions.php" class="btn btn-sm btn-warning">View All</a>
    </div>
    <div class="card-body p-0">
        <?php
        $sql2 = "SELECT * FROM transactions WHERE user_id =:user_id AND trans_type='Loan' ORDER BY trans_id DESC LIMIT 10";
        $wire = $conn->prepare($sql2);
        $wire->execute(['user_id' => $user_id]);

        $sn = 1;
        $hasTransactions = false;

        while ($result = $wire->fetch(PDO::FETCH_ASSOC)) {
            $hasTransactions = true;
            $amount = $result['amount'];
            $isCredit = $result['transaction_type'] === 'credit';
        ?>
            <div class="setting-item">
                <div class="setting-info">
                    <h6 class="mb-1"><?= htmlspecialchars($result['trans_type']) ?></h6>
                    <p class="text-muted mb-0"><?= htmlspecialchars($result['created_at']) ?></p>
                </div>
                <div class="transaction-amount text-<?= $isCredit ? 'success' : 'danger'; ?>">
                    <?= $isCredit ? '+' : '-' ?><?= $currency ?><?php echo number_format($amount, 2, '.', ','); ?>
                </div>
            </div>
        <?php
        }

        if (!$hasTransactions) {
        ?>
            <div class="text-center py-5">
                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No loan transactions yet</h5>
                <p class="text-muted">Your loan transactions will appear here</p>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- Loan Information -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Loan Information</h4>
    </div>
    <div class="card-body p-0">
        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#loanTerms">
            <div class="setting-info">
                <h6 class="mb-1">Loan Terms & Conditions</h6>
                <p class="text-muted mb-0">Interest rates, fees, and repayment terms</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="loanTerms">
            <div class="faq-answer p-3 bg-light">
                <ul class="mb-0">
                    <li><strong>Interest Rate:</strong> 8.5% APR</li>
                    <li><strong>Loan Term:</strong> 24 months</li>
                    <li><strong>Monthly Payment:</strong>
                        <?= $currency ?><?php echo number_format($loan_balance * 0.05, 2, '.', ','); ?></li>
                    <li><strong>Late Fee:</strong> <?= $currency ?>25.00 after 15 days</li>
                    <li><strong>Prepayment:</strong> No penalty for early repayment</li>
                </ul>
            </div>
        </div>

        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#paymentSchedule">
            <div class="setting-info">
                <h6 class="mb-1">Payment Schedule</h6>
                <p class="text-muted mb-0">Upcoming payment dates and amounts</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="paymentSchedule">
            <div class="faq-answer p-3 bg-light">
                <div class="payment-schedule">
                    <div class="payment-item">
                        <span>Next Payment</span>
                        <span
                            class="text-success"><?= $currency ?><?php echo number_format($loan_balance * 0.05, 2, '.', ','); ?></span>
                        <span class="text-muted">Due in 15 days</span>
                    </div>
                    <div class="payment-item">
                        <span>Following Payment</span>
                        <span
                            class="text-success"><?= $currency ?><?php echo number_format($loan_balance * 0.05, 2, '.', ','); ?></span>
                        <span class="text-muted">Due in 45 days</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#loanFaq">
            <div class="setting-info">
                <h6 class="mb-1">Frequently Asked Questions</h6>
                <p class="text-muted mb-0">Common questions about loan management</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="loanFaq">
            <div class="faq-answer p-3 bg-light">
                <h6>How do I make a loan payment?</h6>
                <p class="text-muted">You can make loan payments through the "Make Loan Payment" option above or via
                    bank transfer.</p>

                <h6 class="mt-3">Can I pay off my loan early?</h6>
                <p class="text-muted">Yes, you can pay off your loan early without any prepayment penalties.</p>

                <h6 class="mt-3">What happens if I miss a payment?</h6>
                <p class="text-muted">Late payments may incur fees and affect your credit score. Contact support if
                    you're having trouble
                    making payments.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }

    .card-header {
        background: var(--primary);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.5rem;
    }

    .card-header .card-title {
        margin: 0;
        font-weight: 600;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .card-change {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress {
        height: 100%;
        border-radius: 4px;
        background: var(--primary);
        transition: width 0.3s ease;
    }

    .setting-item {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f8f9fa;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .setting-item:hover {
        background-color: #f8f9fa;
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-info {
        flex: 1;
    }

    .setting-info h6 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .setting-info p {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
    }

    .setting-item i {
        color: #6c757d;
        transition: transform 0.3s ease;
    }

    .transaction-amount {
        font-weight: 600;
        font-size: 1rem;
    }

    .faq-answer {
        border-left: 4px solid var(--primary);
    }

    .faq-answer ul {
        margin-bottom: 0;
    }

    .faq-answer li {
        margin-bottom: 0.5rem;
    }

    .payment-schedule {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .payment-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: white;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    .payment-item span:first-child {
        font-weight: 500;
        color: #2c3e50;
    }

    .payment-item span:nth-child(2) {
        font-weight: 600;
    }

    .payment-item span:last-child {
        font-size: 0.875rem;
    }

    .setting-item[data-bs-toggle="collapse"] i {
        transition: transform 0.3s ease;
    }

    .setting-item[data-bs-toggle="collapse"][aria-expanded="true"] i {
        transform: rotate(90deg);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }

        .setting-item {
            padding: 0.75rem 1rem;
        }

        .card-value {
            font-size: 1.75rem;
        }

        .payment-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }

    @media (max-width: 576px) {
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
        // Handle collapse toggle icons
        const collapseItems = document.querySelectorAll('.setting-item[data-bs-toggle="collapse"]');
        collapseItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                const isExpanded = target.classList.contains('show');

                // Rotate chevron icon
                const icon = this.querySelector('i.fa-chevron-right');
                if (icon) {
                    if (isExpanded) {
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        icon.style.transform = 'rotate(90deg)';
                    }
                }
            });
        });

        // Handle clickable setting items
        const clickableItems = document.querySelectorAll('.setting-item[onclick]');
        clickableItems.forEach(item => {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function() {
                if (this.onclick) {
                    this.onclick();
                } else if (this.getAttribute('onclick')) {
                    eval(this.getAttribute('onclick'));
                }
            });
        });

        // Add smooth animations for cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'fadeInUp 0.6s ease-out';
        });
    });

    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
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