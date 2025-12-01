<?php
$current_page = 'card';
$page_title = 'My Cards';
include 'layout/header.php';

require_once __DIR__ . '/../config.php';
include(ROOT_PATH . "/include/Function/cardFunction.php");

$user_id = userDetails('id');

if (isset($_POST['hold_card'])) {
    $status = 3;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'user_id' => $user_id
    ]);

    if (true) {
        $msg1 = "<div class='alert alert-warning'>
                    <script type='text/javascript'>
                        function Redirect() {
                            window.location='./card.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 3000);
                    </script>
                    <center><img src='../assets/images/loading.gif' width='180px'  /></center>
                    <center><strong style='color:black;'>Please Wait while we validate your request...</strong></center>
                </div>";
    }
}

if (isset($_POST['active_card'])) {
    $status = 1;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'user_id' => $user_id
    ]);

    if (true) {
        $msg1 = "<div class='alert alert-warning'>
                    <script type='text/javascript'>
                        function Redirect() {
                            window.location='./card.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 3000);
                    </script>
                    <center><img src='../assets/images/loading.gif' width='180px'  /></center>
                    <center><strong style='color:black;'>Please Wait while we validate your request...</strong></center>
                </div>";
    }
}

$sql2 = "SELECT * FROM card WHERE user_id=:user_id";
$stmt = $conn->prepare($sql2);
$stmt->execute(['user_id' => $user_id]);
$cardCheck = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">My Cards</h2>
    <div class="page-actions">
        <?php if ($stmt->rowCount() == 0): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CardActionSheet">
                <i class="fas fa-plus me-2"></i>Request New Card
            </button>
        <?php else: ?>
            <?php if ($cardCheck['card_status'] === '1'): ?>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="hold_card" class="btn btn-danger">
                        <i class="fas fa-pause me-2"></i>Deactivate Card
                    </button>
                </form>
            <?php elseif ($cardCheck['card_status'] === '3'): ?>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="active_card" class="btn btn-success">
                        <i class="fas fa-play me-2"></i>Activate Card
                    </button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($msg1)) echo $msg1; ?>

<div class="row">
    <div class="col-lg-6">
        <!-- Card Display Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">Your Card</h4>
            </div>
            <div class="card-body text-center">
                <?php if ($stmt->rowCount() == 0): ?>
                    <!-- No Card - Show Placeholder -->
                    <div class="credit-card placeholder-card">
                        <span class="label"><?= $web_title ?></span>
                        <div class="card-logo">
                            <img src="layout/chip.png" width="25" />
                        </div>
                        <div class="card-number">XXXX XXXX XXXX XXXX</div>
                        <div class="card-details">
                            <div class="card-holder">
                                <div class="card-label">Card Holder</div>
                                <div class="card-value"><?= $fullName ?></div>
                            </div>
                            <div class="card-expiry">
                                <div class="card-label">Expires</div>
                                <div class="card-value">XX/XX</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CardActionSheet">
                            <i class="fas fa-plus me-2"></i>Request Your First Card
                        </button>
                    </div>
                <?php else: ?>
                    <!-- User Has Card -->
                    <div class="credit-card">
                        <div class="card-chip"></div>
                        <div class="card-number"><?= $cardCheck['card_number'] ?></div>
                        <div class="card-details">
                            <div class="card-holder">
                                <div class="card-label">Card Holder</div>
                                <div class="card-value"><?= $fullName ?></div>
                            </div>
                            <div class="card-expiry">
                                <div class="card-label">Expires</div>
                                <div class="card-value"><?= $cardCheck['card_expiration'] ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Card Details Section -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Card Details</h4>
            </div>
            <div class="card-body">
                <div class="setting-item">
                    <div class="setting-info">
                        <h6 class="mb-1">Card Balance</h6>
                        <p class="text-muted mb-0">Available funds on your card</p>
                    </div>
                    <div class="setting-value">
                        <strong><?= $currency ?><?php echo number_format($acct_balance, 2, '.', ','); ?></strong>
                    </div>
                </div>

                <?php if ($stmt->rowCount() > 0): ?>
                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">Card Number</h6>
                            <p class="text-muted mb-0">Your full card number</p>
                        </div>
                        <div class="setting-value">
                            <code><?= $cardCheck['card_number'] ?></code>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">Expiry Date</h6>
                            <p class="text-muted mb-0">Card expiration date</p>
                        </div>
                        <div class="setting-value">
                            <?= $cardCheck['card_expiration'] ?>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">CVC</h6>
                            <p class="text-muted mb-0">Card security code</p>
                        </div>
                        <div class="setting-value">
                            <?= $cardCheck['card_security'] ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <h5>No Active Card</h5>
                        <p class="text-muted">Request a new card to view details</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CardActionSheet">
                            Request Card
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Card Management Section -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Card Management</h4>
            </div>
            <div class="card-body">
                <?php if ($stmt->rowCount() > 0): ?>
                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">Card Status</h6>
                            <p class="text-muted mb-0">Current status of your card</p>
                        </div>
                        <div class="setting-value">
                            <?php
                            switch ($cardCheck['card_status']) {
                                case '1':
                                    echo '<span class="badge bg-success">Active</span>';
                                    break;
                                case '2':
                                    echo '<span class="badge bg-warning">Pending</span>';
                                    break;
                                case '3':
                                    echo '<span class="badge bg-danger">Deactivated</span>';
                                    break;
                                default:
                                    echo '<span class="badge bg-secondary">Unknown</span>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="setting-item">
                    <div class="setting-info">
                        <h6 class="mb-1">Online Payments</h6>
                        <p class="text-muted mb-0">Enable/disable online transactions</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="onlinePayments" checked>
                        <label class="form-check-label" for="onlinePayments"></label>
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <h6 class="mb-1">International Use</h6>
                        <p class="text-muted mb-0">Allow transactions outside your country</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="internationalUse">
                        <label class="form-check-label" for="internationalUse"></label>
                    </div>
                </div>

                <!-- Additional Card Information -->
                <?php if ($stmt->rowCount() > 0): ?>
                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">Billing Address</h6>
                            <p class="text-muted mb-0">Registered address</p>
                        </div>
                        <div class="setting-value">
                            <small><?= $row['acct_address'] ?></small>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">State</h6>
                            <p class="text-muted mb-0">Registered state</p>
                        </div>
                        <div class="setting-value">
                            <?= $row['state'] ?>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">Zipcode</h6>
                            <p class="text-muted mb-0">Postal code</p>
                        </div>
                        <div class="setting-value">
                            <?= $row['zipcode'] ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Request New Card Button -->
                    <div class="setting-item">
                        <div class="setting-info">
                            <h6 class="mb-1">Request New Card</h6>
                            <p class="text-muted mb-0">Get a new card with <?= $currency ?><?= $page['cardfee'] ?> fee</p>
                        </div>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#CardActionSheet">
                            <i class="fas fa-plus me-1"></i>Request
                        </button>
                    </div>
                <?php endif; ?>

                <div class="setting-item">
                    <div class="setting-info">
                        <h6 class="mb-1">Need Help?</h6>
                        <p class="text-muted mb-0">Contact support for card issues</p>
                    </div>
                    <a href="<?= $web_url ?>/user/support.php" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-question-circle me-1"></i>Support
                    </a>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Card Request Modal -->
<div class="modal fade" id="CardActionSheet" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Request New Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" method="post">
                    <div class="mb-3">
                        <label for="pin" class="form-label">
                            Transaction Pin <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="pin" name="pin" inputmode="numeric" required
                            pattern="[0-9]{4}" maxlength="4" autocomplete="off"
                            placeholder="Your 4 Digit Transaction Pin">
                        <div class="form-text">
                            <a href="<?= $web_url ?>/user/ticket.php" class="text-decoration-none">
                                <i class="fas fa-question-circle me-1"></i>Forget account pin? Click to reset
                            </a>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" name="card_generate">
                            <i class="fas fa-credit-card me-2"></i>
                            Request Card - <?= $currency ?><?= $page['cardfee'] ?> Fee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .credit-card {
        position: relative;
        width: 100%;
        max-width: 400px;
        height: 240px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .placeholder-card {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
        opacity: 0.7;
    }

    .active-card {
        background: linear-gradient(135deg, var(--success) 0%, #218838 100%) !important;
    }

    .credit-card .label {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .card-logo {
        margin-bottom: 2rem;
    }

    .card-chip {
        width: 40px;
        height: 30px;
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        border-radius: 5px;
        margin-bottom: 2rem;
        position: relative;
    }

    .card-chip:after {
        content: '';
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .card-number {
        font-size: 1.4rem;
        font-weight: 600;
        letter-spacing: 2px;
        margin-bottom: 2rem;
        font-family: 'Courier New', monospace;
    }

    .card-details {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .card-holder,
    .card-expiry {
        flex: 1;
    }

    .card-label {
        font-size: 0.7rem;
        opacity: 0.8;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-value {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #eaeaea;
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
        margin: 0;
        font-size: 0.875rem;
    }

    .setting-value {
        text-align: right;
    }

    .setting-value code {
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.875rem;
    }

    /* Form switch styling */
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .form-check-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem var(--rgba-primary-2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .credit-card {
            height: 200px;
            padding: 1rem;
        }

        .card-number {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .setting-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .setting-value {
            text-align: left;
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .credit-card {
            height: 180px;
        }

        .card-number {
            font-size: 1rem;
            letter-spacing: 1px;
        }

        .card-label {
            font-size: 0.65rem;
        }

        .card-value {
            font-size: 0.8rem;
        }
    }
</style>

<?php include 'layout/footer.php'; ?>