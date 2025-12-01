<?php
require_once __DIR__ . '/../config.php';
$current_page = 'deposit';
$page_title = 'Crypto Deposit';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

// Initialize alert variables
$alert_message = '';
$alert_type = '';

if (isset($_POST['deposit'])) {
    $amount = $_POST['amount'];
    $crypto_name = $_POST['crypto_name'];
    $wallet_address = $_POST['wallet_address'];
    $user_id = userDetails('id');

    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);

    if (empty($amount) || empty($crypto_name) || empty($wallet_address)) {
        $alert_message = 'Please fill all required fields';
        $alert_type = 'danger';
    } else if (empty($_FILES['image']['name'])) {
        $alert_message = 'Please upload payment screenshot';
        $alert_type = 'danger';
    } elseif ($pin !== $oldPin) {
        $alert_message = 'Incorrect Transaction Pin';
        $alert_type = 'danger';
    } else {
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $name = $file['name'];
            $path = pathinfo($name, PATHINFO_EXTENSION);
            $allowed = array('jpg', 'png', 'jpeg');
            $folder = "../assets/deposit/";
            $n = time() . $name;
            $destination = $folder . $n;
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            if ($acct_stat === 'hold') {
                $alert_message = 'Account on Hold. Contact Support for more information';
                $alert_type = 'danger';
            } elseif ($amount < 0) {
                $alert_message = 'Invalid amount entered';
                $alert_type = 'danger';
            } else {
                $refrence_id = uniqid();
                $trans_type = "Crypto Deposit";
                $transaction_type = "credit";
                $trans_status = "processing";
                $account_name = "N/A";
                $account_number = "N/A";

                $sql = "INSERT INTO transactions (amount,refrence_id,user_id,crypto_id,account_name,bank_name,account_number,trans_type,transaction_type,trans_status,image) VALUES(:amount,:refrence_id,:user_id,:crypto_id,:account_name,:bank_name,:account_number,:trans_type,:transaction_type,:trans_status,:image)";
                $tranfered = $conn->prepare($sql);
                $tranfered->execute([
                    'amount' => $amount,
                    'refrence_id' => $refrence_id,
                    'user_id' => $user_id,
                    'crypto_id' => $crypto_name,
                    'account_name' => $account_name,
                    'bank_name' => $crypto_name,
                    'account_number' => $wallet_address,
                    'trans_type' => $trans_type,
                    'transaction_type' => $transaction_type,
                    'trans_status' => $trans_status,
                    'image' => $n
                ]);

                if ($tranfered) {
                    $full_name = $row['firstname'] . " " . $row['lastname'];
                    $APP_NAME = WEB_TITLE;
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['url_address'];
                    $user_email = $row['acct_email'];
                    $acct_currency = $row['acct_currency'];
                    $message = $sendMail->DepositMsg($full_name, $amount, $trans_type, $trans_status, $refrence_id, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                    // User Email
                    $subject = "Deposit" . "-" . $APP_NAME;
                    $email_message->send_mail($user_email, $message, $subject);

                    $alert_message = 'Your Deposit request is pending. Thanks!';
                    $alert_type = 'success';
                } else {
                    $alert_message = 'Sorry, something went wrong!';
                    $alert_type = 'danger';
                }
            }
        } else {
            $alert_message = 'Failed to upload payment screenshot';
            $alert_type = 'danger';
        }
    }
}

// Get crypto data for JavaScript
$crypto_data = array();
$sql = $conn->query("SELECT * FROM crypto_currency ORDER BY crypto_name");
while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
    $crypto_data[$rs['id']] = $rs['wallet_address'];
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Crypto Deposit</h2>
    <button class="btn btn-primary" onclick="location.reload();">
        <i class="fas fa-refresh me-2"></i>Refresh
    </button>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fab fa-bitcoin me-2 text-warning"></i>
                    Crypto Deposit
                </h4>
            </div>
            <div class="card-body">
                <!-- Bootstrap Alert -->
                <?php if ($alert_message): ?>
                    <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <?php if ($alert_type === 'success'): ?>
                                    <i class="fas fa-check-circle fa-lg"></i>
                                <?php else: ?>
                                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <?= $alert_message ?>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Alert Info -->
                <div class="alert alert-info">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading">Processing Time</h6>
                            <p class="mb-0">Crypto deposits processing might take longer than 30 minutes.</p>
                        </div>
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <!-- Amount -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><?= $currency ?></span>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="0.00"
                                step="0.01" min="0" required
                                value="<?= isset($_POST['amount']) ? $_POST['amount'] : '' ?>">
                        </div>
                        <div class="invalid-feedback">
                            Please enter a valid amount.
                        </div>
                    </div>

                    <!-- Crypto Type -->
                    <div class="mb-3">
                        <label for="crypto_name" class="form-label">Crypto Type <span
                                class="text-danger">*</span></label>
                        <select name="crypto_name" id="crypto_name" onchange="crypto_type(this.value)"
                            class="form-select" required>
                            <option value="">Select Crypto Type</option>
                            <?php
                            $sql = $conn->query("SELECT * FROM crypto_currency ORDER BY crypto_name");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $selected = (isset($_POST['crypto_name']) && $_POST['crypto_name'] == $rs['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $rs['id'] ?>" <?= $selected ?>><?= ucwords($rs['crypto_name']) ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please select a crypto type.
                        </div>
                    </div>

                    <!-- Crypto Wallet Address -->
                    <div class="mb-3">
                        <label for="wallet_address" class="form-label">Crypto Wallet Address <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="wallet_address" name="wallet_address"
                            placeholder="Wallet address will appear after selecting crypto type" readonly required
                            value="<?= isset($_POST['wallet_address']) ? $_POST['wallet_address'] : '' ?>">
                        <div class="form-text">
                            This address will be automatically filled when you select a crypto type.
                        </div>
                        <div class="invalid-feedback">
                            Wallet address is required.
                        </div>
                    </div>

                    <!-- Payment Screenshot -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Payment Screenshot <span
                                class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <div class="form-text">
                            Accepted formats: JPG, PNG, JPEG. Maximum file size: 10MB
                        </div>
                        <div class="invalid-feedback">
                            Please upload a payment screenshot.
                        </div>
                    </div>

                    <!-- Transaction Pin -->
                    <div class="mb-4">
                        <label for="pin" class="form-label">Transaction Pin <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="pin" name="pin" inputmode="numeric"
                            pattern="[0-9]{4}" maxlength="4" placeholder="Enter your 4-digit transaction pin" required>
                        <div class="form-text">
                            <a href="ticket.php" class="text-decoration-none">
                                <i class="fas fa-question-circle me-1"></i>Forgot your transaction pin?
                            </a>
                        </div>
                        <div class="invalid-feedback">
                            Please enter your 4-digit transaction pin.
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="deposit.php" class="btn btn-lg btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Go Back
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-lg btn-primary w-100" name="deposit">
                                <i class="fas fa-paper-plane me-2"></i>Proceed
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2 text-success"></i>
                    Security Tips
                </h4>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Always double-check the wallet address before sending
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Ensure you have sufficient network fees for the transaction
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Keep your transaction details secure and private
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Contact support if you encounter any issues
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    // Crypto data from PHP
    const cryptoData = <?= json_encode($crypto_data) ?>;

    // JavaScript for crypto wallet address update
    function crypto_type(value) {
        const walletInput = document.getElementById('wallet_address');

        if (value === "" || !cryptoData[value]) {
            walletInput.value = "";
            return;
        }

        walletInput.value = cryptoData[value];
    }

    // Bootstrap form validation
    document.addEventListener('DOMContentLoaded', function() {
        'use strict';

        // Fetch all forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });

    // File input validation
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const maxSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if (file) {
            if (file.size > maxSize) {
                alert('File size must be less than 10MB');
                e.target.value = '';
            } else if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, JPEG, PNG)');
                e.target.value = '';
            }
        }
    });
</script>

<!-- Your existing CSS styles remain the same -->
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

    .alert {
        border: none;
        border-radius: 10px;
    }

    .alert-danger {
        border-left: 4px solid var(--danger);
    }

    .alert-success {
        border-left: 4px solid var(--success);
    }

    .alert-info {
        border-left: 4px solid var(--info);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem var(--rgba-primary-2);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e2e8f0;
        border-radius: 8px 0 0 8px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary);
        border: none;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px var(--rgba-primary-3);
    }

    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .was-validated .form-control:invalid,
    .was-validated .form-select:invalid {
        border-color: var(--danger);
    }

    .was-validated .form-control:valid,
    .was-validated .form-select:valid {
        border-color: var(--success);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<?php include 'layout/footer.php'; ?>