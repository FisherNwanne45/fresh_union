<?php
require_once __DIR__ . '/../config.php';
$current_page = 'wire-preview';
$page_title = 'Transaction Preview';
include 'layout/header.php';

require_once(ROOT_PATH . "/include/Transfer/WireFunction.php");

if (!$_SESSION['is_wire_transfer']) {
    header("Location:./dashboard.php");
    exit();
}

$sql = "SELECT * FROM temp_trans WHERE user_id =:user_id AND trans_type='Wire transfer' ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$temp_trans = $stmt->fetch(PDO::FETCH_ASSOC);

$WireFee = $page['wirefee'];
$amount = $temp_trans['amount'];
$totalAmount = $amount + $WireFee;

if (isset($_POST['cancel_transfer'])) {
    $refrence_id = $temp_trans['refrence_id'];

    $delete_sql = "DELETE FROM temp_trans WHERE refrence_id = :refrence_id AND user_id = :user_id";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->execute([
        'refrence_id' => $refrence_id,
        'user_id' => $user_id
    ]);

    // Clear the session flag
    unset($_SESSION['is_wire_transfer']);

    // Redirect back to transfer page
    header("Location: wire-transfer.php");
    exit();
}
?>

<div class="form-head mb-4">
    <h2 class="text-black font-w600 mb-2">Transaction Preview</h2>
    <p class="mb-0 text-muted">Review your international transfer details before proceeding</p>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-8 mx-auto">
        <div class="card border-0 bg-light shadow-sm">
            <div class="card-body text-center py-4">
                <div class="preview-icon mb-4">
                    <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle mx-auto">
                        <i class="fas fa-eye text-primary fa-2x"></i>
                    </div>
                </div>
                <h3 class="text-primary mb-3">Preview Transaction</h3>
                <p class="text-muted mb-4">Please review all details carefully before proceeding</p>
            </div>

            <div class="card-body border-top">
                <div class="transaction-summary">
                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">To</h6>
                                <p class="text-muted mb-0">Recipient Name</p>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($temp_trans['account_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-landmark text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Bank Name</h6>
                                <p class="text-muted mb-0">Recipient Bank</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($temp_trans['bank_name']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Number</h6>
                                <p class="text-muted mb-0">Recipient Account</p>
                            </div>
                        </div>
                        <span class="text-dark fw-bold"><?= htmlspecialchars($temp_trans['account_number']) ?></span>
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
                    <?php
                    $show_swift   = ($page['swift'] == '1');
                    $show_routine = ($page['routine'] == '1');

                    ?>
                    <?php if ($show_routine): ?>
                        <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-sort-numeric-up text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">Routing Number</h6>
                                    <p class="text-muted mb-0">Bank routing identifier</p>
                                </div>
                            </div>
                            <span class="text-dark"><?= htmlspecialchars($temp_trans['routine_number']) ?></span>
                        </div><?php endif; ?>

                    <?php if ($show_swift): ?>
                        <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-code text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">SWIFT Code</h6>
                                    <p class="text-muted mb-0">International bank code</p>
                                </div>
                            </div>
                            <span class="text-dark fw-bold"><?= htmlspecialchars($temp_trans['swift_code']) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tag text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Account Type</h6>
                                <p class="text-muted mb-0">Account classification</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($temp_trans['account_type']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-globe text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Bank Country</h6>
                                <p class="text-muted mb-0">Bank location</p>
                            </div>
                        </div>
                        <span class="text-dark"><?= htmlspecialchars($temp_trans['bank_country']) ?></span>
                    </div>

                    <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hashtag text-primary me-3"></i>
                            <div>
                                <h6 class="mb-1">Reference ID</h6>
                                <p class="text-muted mb-0">Transaction identifier</p>
                            </div>
                        </div>
                        <span class="text-info">#<?= htmlspecialchars($temp_trans['refrence_id']) ?></span>
                    </div>

                    <?php if (!empty($temp_trans['description'])): ?>
                        <div class="summary-item d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-invoice text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">Description</h6>
                                    <p class="text-muted mb-0">Transaction notes</p>
                                </div>
                            </div>
                            <span class="text-dark"><?= htmlspecialchars($temp_trans['description']) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Total Amount -->
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
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-danger btn-lg w-100" data-bs-toggle="modal"
                            data-bs-target="#cancelModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                    </div>
                    <div class="col-6">
                        <form method="POST">
                            <input type="hidden" value="<?= $temp_trans['amount'] ?>" name="amount">
                            <input type="hidden" value="<?= $temp_trans['bank_name'] ?>" name="bank_name">
                            <input type="hidden" value="<?= $temp_trans['account_name'] ?>" name="account_name">
                            <input type="hidden" value="<?= $temp_trans['account_number'] ?>" name="account_number">
                            <input type="hidden" value="<?= $temp_trans['account_type'] ?>" name="account_type">
                            <input type="hidden" value="<?= $temp_trans['trans_type'] ?>" name="trans_type">
                            <input type="hidden" value="<?= $temp_trans['bank_country'] ?>" name="bank_country">
                            <input type="hidden" value="<?= $temp_trans['user_id'] ?>" name="user_id">
                            <input type="hidden" value="<?= $temp_trans['routine_number'] ?>" name="routine_number">
                            <input type="hidden" value="<?= $temp_trans['description'] ?>" name="description">
                            <input type="hidden" value="<?= $temp_trans['swift_code'] ?>" name="swift_code">

                            <button type="submit" class="btn btn-primary btn-lg w-100" name="transfer-preview">
                                <i class="fas fa-check me-2"></i>Proceed
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-success fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Secure International Transaction</h6>
                        <p class="text-muted mb-0">This international transaction is secured with bank-level encryption
                            and complies with global banking regulations.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Cancel Transaction
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="avatar avatar-lg bg-danger bg-opacity-10 rounded-circle mx-auto mb-3">
                    <i class="fas fa-times text-danger fa-2x"></i>
                </div>
                <h5 class="mb-3">Are you sure?</h5>
                <p class="text-muted mb-0">This transaction will be cancelled and all entered data will be lost.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="cancel_transfer" class="btn btn-danger">Yes, Cancel</button>
                </form>
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
        width: 60px;
        height: 60px;
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

    .modal-content {
        border-radius: 12px;
    }

    /* Professional color adjustments */
    :root {
        --primary-rgb: 30, 170, 231;
    }

    /* Responsive design */
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

        .modal-footer {
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-footer .btn {
            width: 100%;
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

        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
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
`;
    document.head.appendChild(style);
</script>

<?php include 'layout/footer.php'; ?>