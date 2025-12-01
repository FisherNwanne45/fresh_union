<?php
require_once __DIR__ . '/../config.php';
$current_page = 'deposit';
$page_title = 'Add Money';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

$user_id = userDetails('id');

// Fetch crypto currencies for QR code modal
$sql = $conn->query("SELECT * FROM crypto_currency ORDER BY crypto_name");
$crypto_currencies = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Add Money</h2>
    <button class="btn btn-primary" onclick="location.reload();">
        <i class="fas fa-refresh me-2"></i>Refresh
    </button>
</div>

<!-- Add Money Section -->
<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Add Money Methods</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Crypto Deposit -->
            <div class="col-md-4 mb-3">
                <a href="crypto-deposit.php" class="card method-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="method-icon bg-primary-light mb-3">
                            <i class="fab fa-bitcoin text-primary fa-2x"></i>
                        </div>
                        <h5 class="method-title">Crypto Deposit</h5>
                        <p class="method-description text-muted">Add money using cryptocurrency</p>
                        <div class="method-arrow">
                            <i class="fas fa-chevron-right text-primary"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Bank Transfer -->
            <div class="col-md-4 mb-3">
                <a href="#" class="card method-card text-decoration-none" data-bs-toggle="modal"
                    data-bs-target="#depositActionSheet">
                    <div class="card-body text-center p-4">
                        <div class="method-icon bg-success-light mb-3">
                            <i class="fas fa-university text-success fa-2x"></i>
                        </div>
                        <h5 class="method-title">Bank Transfer</h5>
                        <p class="method-description text-muted">Receive money with bank details</p>
                        <div class="method-arrow">
                            <i class="fas fa-chevron-right text-success"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Cheque Payments -->
            <div class="col-md-4 mb-3">
                <a href="ticket.php" class="card method-card text-decoration-none">
                    <div class="card-body text-center p-4">
                        <div class="method-icon bg-warning-light mb-3">
                            <i class="fas fa-money-check text-warning fa-2x"></i>
                        </div>
                        <h5 class="method-title">Cheque Payments</h5>
                        <p class="method-description text-muted">Receive cheque payments</p>
                        <div class="method-arrow">
                            <i class="fas fa-chevron-right text-warning"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Digital Payments Section -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Digital Payments</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- QR Code -->
            <div class="col-md-4 mb-3">
                <a href="#" class="card method-card text-decoration-none" data-bs-toggle="modal"
                    data-bs-target="#qrCodeModal">
                    <div class="card-body text-center p-4">
                        <div class="method-icon bg-info-light mb-3">
                            <i class="fas fa-qrcode text-info fa-2x"></i>
                        </div>
                        <h5 class="method-title">Share QR Code</h5>
                        <p class="method-description text-muted">Add money using QR codes</p>
                        <div class="method-arrow">
                            <i class="fas fa-chevron-right text-info"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bank Transfer Modal -->
<div class="modal fade" id="depositActionSheet" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depositModalLabel">Bank Transfer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bank-details text-center">
                    <div class="bank-info mb-4">
                        <h6 class="text-muted mb-2">Account Name</h6>
                        <h4 class="text-primary"><?= $fullName ?></h4>
                    </div>
                    <div class="bank-info mb-4">
                        <h6 class="text-muted mb-2">Account Number</h6>
                        <h4 class="text-primary"><?= $row['acct_no'] ?></h4>
                    </div>
                    <div class="bank-info mb-4">
                        <h6 class="text-muted mb-2">Bank Name</h6>
                        <h5><?= $web_title ?></h5>
                    </div>
                    <div class="bank-info">
                        <h6 class="text-muted mb-2">Reference</h6>
                        <p class="text-muted">Use your account number as reference</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="copyText('<?= $row['acct_no'] ?>', this)">
                    <i class="fas fa-copy me-2"></i>Copy Account Number
                </button>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">
                    <i class="fas fa-qrcode me-2"></i>Crypto Deposit QR Codes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Crypto Tabs -->
                <ul class="nav nav-pills mb-4 justify-content-center" id="cryptoTabs" role="tablist">
                    <?php foreach ($crypto_currencies as $index => $crypto): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $crypto['id'] ?>"
                                data-bs-toggle="pill" data-bs-target="#crypto-<?= $crypto['id'] ?>" type="button" role="tab"
                                aria-controls="crypto-<?= $crypto['id'] ?>"
                                aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                                <i
                                    class="
        <?= strtolower($crypto['crypto_name']) === 'bitcoin' || strtolower($crypto['crypto_name']) === 'ethereum'
                            ? 'fab' // Use 'fab' for brand icons (bitcoin, ethereum)
                            : 'fas' // Use 'fas' for solid icons (money-bill)
        ?>
        fa-<?= strtolower($crypto['crypto_name']) === 'bitcoin' ? 'bitcoin' : (strtolower($crypto['crypto_name']) === 'ethereum' ? 'ethereum' : 'money-bill') ?> me-1">
                                </i>
                                <?= $crypto['crypto_name'] ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Crypto Content -->
                <div class="tab-content" id="cryptoTabContent">
                    <?php foreach ($crypto_currencies as $index => $crypto): ?>
                        <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="crypto-<?= $crypto['id'] ?>"
                            role="tabpanel" aria-labelledby="tab-<?= $crypto['id'] ?>">
                            <div class="row align-items-center">
                                <div class="col-md-6 text-center">
                                    <!-- QR Code Placeholder - You can generate actual QR codes here -->
                                    <div class="qr-code-placeholder bg-light rounded p-4 mb-3">
                                        <div class="qr-code-container">
                                            <!-- This is where the QR code would be displayed -->
                                            <div class="text-muted mb-2">
                                                <i class="fas fa-qrcode fa-5x"></i>
                                            </div>
                                            <small class="text-muted">QR Code for <?= $crypto['crypto_name'] ?></small>
                                        </div>
                                    </div>
                                    <small class="text-muted">Scan to deposit <?= $crypto['crypto_name'] ?></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="crypto-info">
                                        <h6 class="text-muted mb-2">Wallet Address</h6>
                                        <div class="wallet-address-container mb-3">
                                            <code class="wallet-address d-block p-3 bg-light rounded font-monospace">
                                                <?= $crypto['wallet_address'] ?>
                                            </code>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary w-100"
                                            onclick="copyText('<?= $crypto['wallet_address'] ?>', this)">
                                            <i class="fas fa-copy me-2"></i>Copy Wallet Address
                                        </button>

                                        <div class="mt-4">
                                            <h6 class="text-muted mb-2">Deposit Instructions</h6>
                                            <ul class="list-unstyled small">
                                                <li class="mb-2">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    Send only <?= $crypto['crypto_name'] ?> to this address
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    Ensure network compatibility
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    Transaction may take 10-30 minutes
                                                </li>
                                                <li>
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    Minimum deposit: Network fee + $10
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="crypto-deposit.php" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Make Crypto Deposit
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .method-card {
        border: 1px solid #eaeaea;
        transition: all 0.3s ease;
        height: 100%;
    }

    .method-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .method-icon {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .method-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .method-description {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .method-arrow {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .method-card:hover .method-arrow {
        opacity: 1;
    }

    .bank-info {
        padding: 1rem;
        border-radius: 10px;
        background: #f8f9fa;
    }

    .bank-info h4,
    .bank-info h5 {
        margin: 0;
        font-weight: 600;
    }

    /* QR Code Modal Styles */
    .qr-code-placeholder {
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #dee2e6;
    }

    .wallet-address {
        word-break: break-all;
        font-size: 0.85rem;
        line-height: 1.4;
    }

    .nav-pills .nav-link {
        border-radius: 20px;
        margin: 0 5px;
        padding: 0.5rem 1rem;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .nav-pills .nav-link.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
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

    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .method-icon {
            width: 60px;
            height: 60px;
        }

        .method-icon i {
            font-size: 1.5rem !important;
        }

        .card-body.p-4 {
            padding: 1.5rem !important;
        }

        .qr-code-placeholder {
            min-height: 200px;
        }

        .wallet-address {
            font-size: 0.75rem;
        }

        .nav-pills .nav-link {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            margin: 2px;
        }
    }

    @media (max-width: 576px) {
        .modal-dialog.modal-lg {
            margin: 0.5rem;
        }

        .qr-code-placeholder {
            min-height: 150px;
        }

        .qr-code-placeholder .fa-5x {
            font-size: 3rem;
        }
    }
</style>

<script>
    // Generic copy text function
    function copyText(text, button) {
        // Create a temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);

        // Select and copy the text
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                // Show success feedback
                if (button) {
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
                    button.classList.remove('btn-primary', 'btn-outline-primary');
                    button.classList.add('btn-success');

                    // Revert after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.classList.remove('btn-success');
                        if (originalText.includes('btn-outline-primary')) {
                            button.classList.add('btn-outline-primary');
                        } else {
                            button.classList.add('btn-primary');
                        }
                    }, 2000);
                }
            }
        } catch (err) {
            console.error('Failed to copy: ', err);
            alert('Failed to copy. Please copy manually: ' + text);
        }

        // Clean up
        document.body.removeChild(tempInput);
    }

    // Initialize tooltips if any
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Auto-select first tab when modal opens
    document.getElementById('qrCodeModal').addEventListener('show.bs.modal', function() {
        // Ensure first tab is active
        const firstTab = document.querySelector('#cryptoTabs .nav-link');
        if (firstTab && !firstTab.classList.contains('active')) {
            firstTab.click();
        }
    });
</script>

<?php include 'layout/footer.php'; ?>