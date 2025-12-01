<?php
require_once __DIR__ . '/../config.php';
$current_page = 'imf-verification';
$page_title = 'Verification';
include 'layout/header.php';

require_once(ROOT_PATH . "/include/Transfer/DomesticFunction.php");

if (!isset($_SESSION['is_transfer'])) {
    header("Location:./dashboard.php");
}

if (!isset($_SESSION['is_tax_code'])) {
    header("Location:./domestic-transfer.php");
    exit();
}

unset($_SESSION['is_cot_code']);

$error = '';
if (isset($_POST['imf_submit'])) {
    $imf_code = $_POST['imf_code'];
    $imf = $row['acct_imf'];

    $acct_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 4);

    $sql =  "UPDATE users SET acct_otp=:acct_otp WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_otp' => $acct_otp,
        'id' => $user_id
    ]);

    $full_name = $row['firstname'] . " " . $row['lastname'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $row['acct_email'];

    $message = $sendMail->pinRequest($full_name, $acct_otp, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    $subject = "One-Time Code - $APP_NAME";
    $email_message->send_mail($email, $message, $subject);

    if ($imf_code === $imf) {
        $_SESSION['domestic-transfer'] = $user_id;
        $_SESSION['is_dom_transfer'] = "Dom";
        $_SESSION['is__transfer'] = "None";
        $_SESSION['is_transfer']  = "transfer";
        $_SESSION['is_tax_code'] = "None";

        header("Location:./dom-pin.php");
        exit();
    } else {
        $error = 'Invalid Code';
    }
}
?>

<div class="form-head mb-4">
    <h2 class="text-black font-w600 mb-2"><?= $page['code2'] ?> Confirmed</h2>
    <p class="mb-0 text-muted"><?= $page['code3'] ?> verification in progress</p>
</div>

<?php if ($error): ?>
<div class="row">
    <div class="col-xl-6 col-lg-8 mx-auto">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-xl-6 col-lg-8 mx-auto">
        <div class="card border-0 bg-light shadow-sm mb-4" id="progressSection">
            <div class="card-body text-center py-5">
                <div class="verification-icon mb-4">
                    <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle mx-auto">
                        <i class="fas fa-shield-alt text-primary fa-2x"></i>
                    </div>
                </div>
                <h3 class="text-primary mb-3"> <?= $page['code2'] ?> Verified</h3>
                <p class="text-muted mb-4">Please wait while we verify <?= $page['code3'] ?> requirements</p>

                <div class="loading-progress-container mx-auto" style="max-width: 400px;">
                    <div class="loading-progress-bar" id="loading-progress-bar"></div>
                    <div class="loading-progress-text" id="loading-progress-text">73%</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" id="verificationForm" style="display: none;">
            <div class="card-body text-center py-4">
                <div class="verification-icon mb-4">
                    <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle mx-auto">
                        <i class="fas fa-globe-americas text-info fa-2x"></i>
                    </div>
                </div>
                <h3 class="text-info mb-3">Enter <?= $page['code3'] ?> Code</h3>
                <p class="text-muted mb-4">Please enter the 4-digit <?= $page['code3'] ?> verification code</p>

                <div class="pin-container mb-4">
                    <div class="d-flex justify-content-center gap-3">
                        <div class="pin-square">
                            <input type="text" maxlength="1" class="pin-input" data-index="0" readonly>
                        </div>
                        <div class="pin-square">
                            <input type="text" maxlength="1" class="pin-input" data-index="1" readonly>
                        </div>
                        <div class="pin-square">
                            <input type="text" maxlength="1" class="pin-input" data-index="2" readonly>
                        </div>
                        <div class="pin-square">
                            <input type="text" maxlength="1" class="pin-input" data-index="3" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body border-top">
                <div class="virtual-keypad">
                    <!-- Same keypad structure -->
                    <div class="row g-2 mb-3">
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="1">1</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="2">2</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="3">3</button></div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="4">4</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="5">5</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="6">6</button></div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="7">7</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="8">8</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="9">9</button></div>
                    </div>
                    <div class="row g-2">
                        <div class="col-4"><button type="button" class="btn btn-keypad btn-clear w-100 py-3"><i
                                    class="fas fa-undo"></i></button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad w-100 py-3"
                                data-number="0">0</button></div>
                        <div class="col-4"><button type="button" class="btn btn-keypad btn-backspace w-100 py-3"><i
                                    class="fas fa-backspace"></i></button></div>
                    </div>
                </div>

                <form method="POST" id="verificationFormSubmit">
                    <input type="hidden" name="imf_code" id="finalCode">
                    <input type="hidden" value="<?= $temp_trans['amount'] ?>" name="amount">
                    <input type="hidden" value="<?= $temp_trans['bank_name'] ?>" name="bank_name">
                    <input type="hidden" value="<?= $temp_trans['account_name'] ?>" name="account_name">
                    <input type="hidden" value="<?= $temp_trans['account_number'] ?>" name="account_number">
                    <input type="hidden" value="<?= $temp_trans['account_type'] ?>" name="account_type">
                    <input type="hidden" value="<?= $temp_trans['trans_type'] ?>" name="trans_type">
                    <input type="hidden" value="<?= $temp_trans['bank_country'] ?>" name="bank_country">
                    <input type="hidden" value="<?= $temp_trans['user_id'] ?>" name="user_id">
                    <input type="hidden" value="<?= $temp_trans['description'] ?>" name="description">

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="imf_submit" class="btn btn-info btn-lg py-3" id="submitBtn"
                            disabled>
                            <i class="fas fa-check-circle me-2"></i>Verify <?= $page['code3'] ?> Code
                        </button>
                    </div>
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
    width: 80px;
    height: 80px;
}

.loading-progress-container {
    position: relative;
    width: 100%;
    height: 12px;
    background: #e9ecef;
    border-radius: 6px;
    overflow: hidden;
}

.loading-progress-bar {
    width: 0%;
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    transition: width 0.3s ease-in-out;
    border-radius: 6px;
}

.loading-progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
}

.pin-container {
    max-width: 280px;
    margin: 0 auto;
}

.pin-square {
    width: 60px;
    height: 60px;
    border: 2px solid #eef2f7;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    background: #fff;
}

.pin-square.active {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem var(--rgba-primary-1);
}

.pin-input {
    width: 100%;
    height: 100%;
    border: none;
    background: transparent;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary);
    outline: none;
}

.virtual-keypad {
    max-width: 300px;
    margin: 0 auto;
}

.btn-keypad {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1.25rem;
    font-weight: 600;
    color: #495057;
    transition: all 0.3s ease;
    height: 60px;
}

.btn-keypad:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

.btn-keypad:active {
    transform: translateY(0);
}

.btn-clear,
.btn-backspace {
    background: #fff5f5;
    border-color: #fed7d7;
    color: #e53e3e;
}

.btn-clear:hover,
.btn-backspace:hover {
    background: #e53e3e;
    color: white;
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
}

.btn-info:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
}

.btn-info:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
}

.alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

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

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }

    .avatar {
        width: 60px;
        height: 60px;
    }

    .pin-square {
        width: 50px;
        height: 50px;
    }

    .btn-keypad {
        height: 50px;
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }

    .form-head {
        text-align: center;
    }

    .pin-square {
        width: 45px;
        height: 45px;
    }

    .pin-input {
        font-size: 1.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.getElementById('loading-progress-bar');
    const progressText = document.getElementById('loading-progress-text');
    const progressSection = document.getElementById('progressSection');
    const verificationForm = document.getElementById('verificationForm');

    let progressValue = 73;

    function updateProgressBar() {
        progressBar.style.width = `${progressValue}%`;
        progressText.textContent = `${progressValue}%`;

        if (progressValue === 95) {
            setTimeout(() => {
                progressSection.style.display = 'none';
                verificationForm.style.display = 'block';
                verificationForm.classList.add('fade-in-up');
                initializeKeypad();
            }, 300);
        } else if (progressValue < 95) {
            progressValue++;
            setTimeout(updateProgressBar, 285);
        }
    }

    function initializeKeypad() {
        // Same keypad initialization as cot.php
        const pinInputs = document.querySelectorAll('.pin-input');
        const finalCode = document.getElementById('finalCode');
        const submitBtn = document.getElementById('submitBtn');
        let currentIndex = 0;
        let code = ['', '', '', ''];

        function updateActiveState() {
            pinInputs.forEach((input, index) => {
                const square = input.parentElement;
                if (index === currentIndex) {
                    square.classList.add('active');
                } else {
                    square.classList.remove('active');
                }
            });
        }

        function updateFinalCode() {
            finalCode.value = code.join('');
            submitBtn.disabled = code.join('').length !== 4;
        }

        function inputNumber(num) {
            if (currentIndex < 4) {
                code[currentIndex] = num;
                pinInputs[currentIndex].value = num;
                currentIndex++;
                updateActiveState();
                updateFinalCode();
            }
        }

        function handleBackspace() {
            if (currentIndex > 0) {
                currentIndex--;
                code[currentIndex] = '';
                pinInputs[currentIndex].value = '';
                updateActiveState();
                updateFinalCode();
            }
        }

        function handleClear() {
            code = ['', '', '', ''];
            pinInputs.forEach(input => input.value = '');
            currentIndex = 0;
            updateActiveState();
            updateFinalCode();
        }

        document.querySelectorAll('.btn-keypad[data-number]').forEach(button => {
            button.addEventListener('click', function() {
                inputNumber(this.getAttribute('data-number'));
            });
        });

        document.querySelector('.btn-backspace').addEventListener('click', handleBackspace);
        document.querySelector('.btn-clear').addEventListener('click', handleClear);

        updateActiveState();

        document.addEventListener('keydown', function(e) {
            if (e.key >= '0' && e.key <= '9') {
                inputNumber(e.key);
            } else if (e.key === 'Backspace') {
                handleBackspace();
            } else if (e.key === 'Escape') {
                handleClear();
            }
        });
    }

    updateProgressBar();

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>

<?php include 'layout/footer.php'; ?>