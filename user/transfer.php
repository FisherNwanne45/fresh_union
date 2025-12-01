<?php
require_once __DIR__ . '/../config.php';
$current_page = 'transfer';
$page_title = 'Send Money';
include 'layout/header.php';

$user_id = userDetails('id');

if ($row['acct_status'] === 'suspend') {
    header('Location: dashboard.php?dormant#dormant');
    exit();
}
?>

<div class="form-head mb-4">
    <h2 class="text-black font-w600 mb-2">Send Money</h2>
    <p class="mb-0 text-muted">Choose your preferred transfer method</p>
</div>

<div class="row">

    <!-- Transfer Methods -->
    <div class="col-xl-8 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-0 text-primary">Transfer Methods</h5>
                <p class="text-muted mb-0"><i class="fas fa-wallet text-primary"></i>
                    Balance: <?= $currency ?><?= number_format($row['acct_balance'], 2) ?></p>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Domestic Transfer -->
                    <div class="col-md-6">
                        <div class="method-card card h-100 border-0 bg-light-hover"
                            onclick="location.href='domestic-transfer.php'">
                            <div class="card-body text-center p-4">
                                <div class="method-icon mx-auto mb-3">
                                    <i class="fas fa-landmark"></i>
                                </div>
                                <h6 class="method-title mb-2">Domestic Transfer</h6>
                                <p class="method-desc text-muted small mb-3">
                                    Send money to local bank accounts within the country
                                </p>
                                <div class="method-features">
                                    <span class="badge bg-primary bg-opacity-10 text-white small">Instant</span>
                                    <span class="badge bg-primary bg-opacity-10 text-white small">Secure</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Wire Transfer -->
                    <div class="col-md-6">
                        <div class="method-card card h-100 border-0 bg-light-hover"
                            onclick="location.href='wire-transfer.php'">
                            <div class="card-body text-center p-4">
                                <div class="method-icon mx-auto mb-3">
                                    <i class="fas fa-globe-americas"></i>
                                </div>
                                <h6 class="method-title mb-2">International Transfer</h6>
                                <p class="method-desc text-muted small mb-3">
                                    Send money worldwide with competitive exchange rates
                                </p>
                                <div class="method-features">
                                    <span class="badge bg-warning bg-opacity-10 text-warning small">1-2 Days</span>
                                    <span class="badge bg-primary bg-opacity-10 text-white small">150+
                                        Countries</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Cryptocurrency -->
                    <div class="col-md-6">
                        <div class="method-card card h-100 border-0 bg-light-hover"
                            onclick="location.href='crypto-withdrawal.php'">
                            <div class="card-body text-center p-4">
                                <div class="method-icon mx-auto mb-3">
                                    <i class="fab fa-bitcoin"></i>
                                </div>
                                <h6 class="method-title mb-2">Cryptocurrency</h6>
                                <p class="method-desc text-muted small mb-3">
                                    Withdraw to your crypto wallets with real-time rates
                                </p>
                                <div class="method-features">
                                    <span class="badge bg-success bg-opacity-10 text-success small">24/7</span>
                                    <span class="badge bg-primary bg-opacity-10 text-white small">Multiple
                                        Coins</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Coming Soon -->
                    <div class="col-md-6">
                        <div class="method-card card h-100 border-0 bg-light">
                            <div class="card-body text-center p-4">
                                <div class="method-icon mx-auto mb-3 opacity-50">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h6 class="method-title mb-2">Mobile Wallet</h6>
                                <p class="method-desc text-muted small mb-3">
                                    Transfer to mobile money wallets and payment apps
                                </p>
                                <div class="method-features">
                                    <span class="badge bg-secondary small">Coming Soon</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transfers --
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Transfers</h5>
                <a href="transactions.php" class="btn btn-link btn-sm p-0">View All</a>
            </div>
            <div class="card-body">
                <?php
                $recent_sql = "SELECT * FROM transactions WHERE user_id = :user_id AND trans_type IN ('Transfer', 'Wire Transfer') ORDER BY trans_id DESC LIMIT 3";
                $recent_stmt = $conn->prepare($recent_sql);
                $recent_stmt->execute(['user_id' => $user_id]);
                $hasRecent = false;

                while ($recent = $recent_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $hasRecent = true;
                    $isCredit = $recent['transaction_type'] === 'credit';
                ?>
                <div class="transfer-item d-flex align-items-center py-3 border-bottom">
                    <div class="transfer-icon flex-shrink-0">
                        <div class="avatar avatar-sm bg-<?= $isCredit ? 'success' : 'danger' ?>-subtle rounded-circle">
                            <i class="fas fa-<?= $isCredit ? 'arrow-down text-success' : 'arrow-up text-danger' ?>"></i>
                        </div>
                    </div>
                    <div class="transfer-details flex-grow-1 ms-3">
                        <h6 class="mb-1"><?= htmlspecialchars($recent['trans_type']) ?></h6>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($recent['created_at']) ?></p>
                    </div>
                    <div class="transfer-amount text-end">
                        <h6 class="mb-1 text-<?= $isCredit ? 'success' : 'danger' ?>">
                            <?= $isCredit ? '+' : '-' ?><?= $currency ?><?= number_format($recent['amount'], 2) ?>
                        </h6>
                        <span
                            class="badge bg-<?= $isCredit ? 'success' : 'danger' ?>-subtle text-<?= $isCredit ? 'success' : 'danger' ?> small">
                            <?= ucfirst($recent['status'] ?? 'Completed') ?>
                        </span>
                    </div>
                </div>
                <?php
                }

                if (!$hasRecent) {
                ?>
                <div class="text-center py-4">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-exchange-alt fa-2x text-muted"></i>
                    </div>
                    <h6 class="text-muted">No recent transfers</h6>
                    <p class="text-muted small">Your transfer history will appear here</p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>-->
    </div>

    <!-- Account Summary -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0 text-primary">Account Summary</h5>
            </div>
            <div class="card-body">
                <!--<div class="d-flex align-items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-primary rounded-circle">
                            <i class="fas fa-wallet text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Available Balance</h6>
                        <h4 class="text-primary mb-0"><?= $currency ?><?= number_format($row['acct_balance'], 2) ?></h4>
                    </div>
                </div>-->

                <div class="balance-stats">
                    <div class="stat-item d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Daily Limit</span>
                        <span
                            class="fw-bold text-dark"><?= $currency ?><?= number_format($row['limit_remain'], 2) ?></span>
                    </div>
                    <div class="stat-item d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Account Status</span>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="stat-item d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Security</span>
                        <span class="text-success"><i class="fas fa-shield-check me-1"></i>Protected</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0 text-primary">Quick Actions</h5>
            </div>
            <div class="card-body">
                <style>
                    .action-card {
                        border-radius: 12px;
                        padding: 16px;
                        text-align: center;
                        transition: all 0.25s ease;
                        cursor: pointer;
                    }

                    .action-card i {
                        font-size: 26px;
                        margin-bottom: 8px;
                    }

                    .action-card:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
                    }

                    .action-card-text {
                        font-size: 11px;
                        /* smaller text */
                        font-weight: 400;
                        /* normal, not bold */
                        margin-top: 4px;
                    }
                </style>

                <div class="container mt-3">
                    <div class="row g-3">

                        <!-- Add Beneficiary -->
                        <div class="col-6">
                            <a href="beneficiaries.php" class="text-decoration-none text-dark">
                                <div class="action-card bg-primary bg-opacity-10">
                                    <i class="fas fa-user-plus text-white"></i>
                                    <div class="action-card-text text-white">Add Beneficiary</div>
                                </div>
                            </a>
                        </div>

                        <!-- Manage Beneficiaries -->
                        <div class="col-6">
                            <a href="beneficiaries.php#all" class="text-decoration-none text-dark">
                                <div class="action-card bg-success bg-opacity-10">
                                    <i class="fas fa-address-book text-success"></i>
                                    <div class="action-card-text">All Beneficiaries</div>
                                </div>
                            </a>
                        </div>

                        <!-- Transfer History -->
                        <div class="col-6">
                            <a href="transactions.php" class="text-decoration-none text-dark">
                                <div class="action-card bg-secondary bg-opacity-10">
                                    <i class="fas fa-history text-secondary"></i>
                                    <div class="action-card-text">Transfer History</div>
                                </div>
                            </a>
                        </div>

                        <!-- Contact Support -->
                        <div class="col-6">
                            <a href="support.php" class="text-decoration-none text-dark">
                                <div class="action-card bg-warning bg-opacity-10">
                                    <i class="fas fa-headset text-warning"></i>
                                    <div class="action-card-text">Support</div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="deposit.php" class="btn btn-primary btn-sm mb-2">
                        <i class="fas fa-plus me-2"></i>Top up Balance
                    </a>
                    <a href="card.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-credit-card me-2"></i>Card payment
                    </a>
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

    .card-header {
        padding: 1.25rem 1.25rem 0.5rem;
    }

    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
    }

    .avatar-lg {
        width: 60px;
        height: 60px;
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .balance-stats {
        border-top: 1px solid #eef2f7;
        padding-top: 1rem;
    }

    .method-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid #eef2f7;
    }

    .method-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        border-color: var(--primary);
    }

    .method-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .method-card:not(:hover) .method-icon {
        background: #f8f9fa;
        color: var(--primary);
    }

    .method-title {
        font-weight: 600;
        color: #2c3e50;
    }

    .method-desc {
        line-height: 1.5;
        min-height: 40px;
    }

    .method-features {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .bg-light-hover:hover {
        background-color: #fafbfe !important;
    }

    .bg-primary-subtle {
        background-color: rgba(var(--primary-rgb), 0.1) !important;
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1) !important;
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

    .btn-outline-primary:hover {
        transform: translateY(-1px);
    }

    /* Professional color adjustments */
    :root {
        --primary-rgb: 30, 170, 231;
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .bg-primary {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .method-card {
            margin-bottom: 1rem;
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

        .method-icon {
            width: 60px;
            height: 60px;
            font-size: 1.25rem;
        }

        .avatar-lg {
            width: 50px;
            height: 50px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'fadeInUp 0.6s ease-out';
        });

        // Add click effects for method cards
        const methodCards = document.querySelectorAll('.method-card[onclick]');
        methodCards.forEach(card => {
            card.addEventListener('click', function() {
                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(0,0,0,0.1);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;

                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = event.clientX - rect.left - size / 2;
                const y = event.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';

                this.style.position = 'relative';
                this.appendChild(ripple);

                setTimeout(() => {
                    const href = this.getAttribute('onclick')?.match(
                        /location\.href='([^']+)'/)?.[1];
                    if (href) {
                        window.location.href = href;
                    }
                }, 300);
            });
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

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.method-card {
    position: relative;
    overflow: hidden;
}
`;
    document.head.appendChild(style);
</script>

<?php include 'layout/footer.php'; ?>