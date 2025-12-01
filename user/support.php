<?php
require_once __DIR__ . '/../config.php';
$current_page = 'support';
$page_title = 'Help & Support';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Help & Support</h2>
    <a href="ticket.php" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create Ticket
    </a>
</div>

<!-- Quick Support Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card support-card text-center">
            <div class="card-body p-4">
                <div class="support-icon bg-primary-light mb-3">
                    <i class="fas fa-envelope text-primary fa-2x"></i>
                </div>
                <h5 class="support-title">Email Support</h5>
                <p class="support-description text-muted">Get help via email</p>
                <a href="mailto:<?= $page['url_email'] ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-envelope me-1"></i>Email Us
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card support-card text-center">
            <div class="card-body p-4">
                <div class="support-icon bg-success-light mb-3">
                    <i class="fas fa-ticket-alt text-success fa-2x"></i>
                </div>
                <h5 class="support-title">Support Ticket</h5>
                <p class="support-description text-muted">Create a support ticket</p>
                <a href="ticket.php" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus me-1"></i>Create Ticket
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card support-card text-center">
            <div class="card-body p-4">
                <div class="support-icon bg-warning-light mb-3">
                    <i class="fas fa-phone text-warning fa-2x"></i>
                </div>
                <h5 class="support-title">Phone Support</h5>
                <p class="support-description text-muted">Call our support line</p>
                <a href="tel:<?= $page['url_tel'] ?? '+1-800-123-4567' ?>" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-phone me-1"></i>Call Now
                </a>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Frequently Asked Questions</h4>
    </div>
    <div class="card-body">
        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#faq1">
            <div class="setting-info">
                <h6 class="mb-1">How do I reset my transaction PIN?</h6>
                <p class="text-muted mb-0">Steps to reset your 4-digit transaction PIN</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="faq1">
            <div class="faq-answer p-3 bg-light rounded mt-2">
                <p>To reset your transaction PIN:</p>
                <ol>
                    <li>Go to the "Support" section</li>
                    <li>Create a new support ticket</li>
                    <li>Select "Forgot PIN" as the issue type</li>
                    <li>Our team will verify your identity and reset your PIN</li>
                    <li>You'll receive a temporary PIN via email</li>
                </ol>
            </div>
        </div>

        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#faq2">
            <div class="setting-info">
                <h6 class="mb-1">How long do crypto deposits take?</h6>
                <p class="text-muted mb-0">Processing times for cryptocurrency deposits</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="faq2">
            <div class="faq-answer p-3 bg-light rounded mt-2">
                <p>Crypto deposit processing times:</p>
                <ul>
                    <li><strong>Bitcoin (BTC):</strong> 10-30 minutes (3 network confirmations)</li>
                    <li><strong>Ethereum (ETH):</strong> 5-15 minutes (12 network confirmations)</li>
                    <li><strong>Litecoin (LTC):</strong> 5-10 minutes (6 network confirmations)</li>
                    <li><strong>Other cryptocurrencies:</strong> Varies by network</li>
                </ul>
                <p class="text-muted mb-0"><small>Processing may take longer during network congestion.</small></p>
            </div>
        </div>

        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#faq3">
            <div class="setting-info">
                <h6 class="mb-1">What are the transaction limits?</h6>
                <p class="text-muted mb-0">Daily and monthly transaction limits</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="faq3">
            <div class="faq-answer p-3 bg-light rounded mt-2">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Daily Limits</h6>
                        <ul class="list-unstyled">
                            <li>Send Money:
                                <?= $currency ?><?= number_format($page['daily_transfer_limit'] ?? 5000, 2) ?></li>
                            <li>Withdrawals:
                                <?= $currency ?><?= number_format($page['daily_withdrawal_limit'] ?? 2000, 2) ?></li>
                            <li>Deposits: <?= $currency ?><?= number_format($page['daily_deposit_limit'] ?? 10000, 2) ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Monthly Limits</h6>
                        <ul class="list-unstyled">
                            <li>Total Transactions:
                                <?= $currency ?><?= number_format($page['monthly_limit'] ?? 50000, 2) ?></li>
                            <li>Card Purchases: <?= $currency ?><?= number_format($page['card_limit'] ?? 10000, 2) ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="text-muted mb-0"><small>Limits may vary based on account verification level.</small></p>
            </div>
        </div>

        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#faq4">
            <div class="setting-info">
                <h6 class="mb-1">How do I report a lost card?</h6>
                <p class="text-muted mb-0">Steps to report and replace a lost or stolen card</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="faq4">
            <div class="faq-answer p-3 bg-light rounded mt-2">
                <p>If your card is lost or stolen:</p>
                <ol>
                    <li>Immediately go to "My Cards" in your dashboard</li>
                    <li>Click "Deactivate Card" to freeze it temporarily</li>
                    <li>Create a support ticket for card replacement</li>
                    <li>Card replacement fee: <?= $currency ?><?= number_format($page['cardfee'] ?? 15, 2) ?></li>
                    <li>New card will be shipped within 5-7 business days</li>
                </ol>
                <div class="alert alert-warning mt-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Important:</strong> Report lost cards immediately to prevent unauthorized transactions.
                </div>
            </div>
        </div>

        <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#faq5">
            <div class="setting-info">
                <h6 class="mb-1">What are your transfer fees?</h6>
                <p class="text-muted mb-0">Fees for different types of transfers</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="collapse" id="faq5">
            <div class="faq-answer p-3 bg-light rounded mt-2">
                <h6>Transfer Fees</h6>
                <ul class="list-unstyled">
                    <li>Domestic Transfers: <?= $currency ?><?= number_format($page['domesticfee'] ?? 2.50, 2) ?></li>
                    <li>Wire Transfers: <?= $currency ?><?= number_format($page['wirefee'] ?? 25.00, 2) ?></li>
                    <li>Interbank Transfers: <?= $currency ?><?= number_format($page['interbank_fee'] ?? 1.50, 2) ?>
                    </li>
                    <li>Card Request: <?= $currency ?><?= number_format($page['cardfee'] ?? 15.00, 2) ?></li>
                </ul>
                <p class="text-muted mb-0"><small>Fees are subject to change. Always check current fees before
                        initiating transfers.</small></p>
            </div>
        </div>
    </div>
</div>

<!-- Contact Support Section -->
<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Contact Support</h4>
    </div>
    <div class="card-body">
        <div class="setting-item" onclick="location.href='mailto:<?= $page['url_email'] ?>'">
            <div class="setting-info">
                <h6 class="mb-1">Email Support</h6>
                <p class="text-muted mb-0"><?= $page['url_email'] ?></p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="setting-item" onclick="location.href='ticket.php'">
            <div class="setting-info">
                <h6 class="mb-1">Support Ticket</h6>
                <p class="text-muted mb-0">Create a support ticket for personalized assistance</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <?php if (!empty($page['url_phone'])): ?>
            <div class="setting-item" onclick="location.href='tel:<?= $page['url_phone'] ?>'">
                <div class="setting-info">
                    <h6 class="mb-1">Phone Support</h6>
                    <p class="text-muted mb-0"><?= $page['url_phone'] ?></p>
                </div>
                <i class="fas fa-chevron-right"></i>
            </div>
        <?php endif; ?>

        <?php if (!empty($page['url_address'])): ?>
            <div class="setting-item">
                <div class="setting-info">
                    <h6 class="mb-1">Office Address</h6>
                    <p class="text-muted mb-0"><?= $page['url_address'] ?></p>
                </div>
                <i class="fas fa-map-marker-alt text-muted"></i>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Legal & Compliance Section -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Legal & Compliance</h4>
    </div>
    <div class="card-body">
        <div class="setting-item">
            <div class="setting-info">
                <h6 class="mb-1">Privacy Policy</h6>
                <p class="text-muted mb-0">How we protect and use your data</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h6 class="mb-1">Terms of Service</h6>
                <p class="text-muted mb-0">Our terms and conditions</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h6 class="mb-1">Security Information</h6>
                <p class="text-muted mb-0">How we keep your account secure</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="setting-item">
            <div class="setting-info">
                <h6 class="mb-1">Compliance</h6>
                <p class="text-muted mb-0">Regulatory compliance information</p>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>
</div>

<style>
    .support-card {
        border: 1px solid #eaeaea;
        transition: all 0.3s ease;
        height: 100%;
    }

    .support-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .support-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .support-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .support-description {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .setting-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #f8f9fa;
        cursor: pointer;
        transition: background-color 0.2s ease;
        border-radius: 8px;
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

    .setting-item[data-bs-toggle="collapse"] i {
        transition: transform 0.3s ease;
    }

    .setting-item[data-bs-toggle="collapse"][aria-expanded="true"] i {
        transform: rotate(90deg);
    }

    .faq-answer {
        border-left: 4px solid var(--primary);
    }

    .faq-answer ol,
    .faq-answer ul {
        margin-bottom: 1rem;
    }

    .faq-answer li {
        margin-bottom: 0.5rem;
    }

    /* Light background classes */
    .bg-primary-light {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .support-icon {
            width: 60px;
            height: 60px;
        }

        .support-icon i {
            font-size: 1.5rem !important;
        }

        .card-body {
            padding: 1.25rem;
        }

        .setting-item {
            padding: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click handlers for setting items without collapse
        const settingItems = document.querySelectorAll('.setting-item');
        settingItems.forEach(item => {
            if (!item.getAttribute('data-bs-toggle') && item.onclick) {
                item.style.cursor = 'pointer';
                item.addEventListener('click', function() {
                    if (this.onclick) {
                        this.onclick();
                    }
                });
            }
        });

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
    });
</script>

<?php include 'layout/footer.php'; ?>