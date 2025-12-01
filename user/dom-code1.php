<?php
$pageName  = "Verification";
require_once __DIR__ . '/../config.php';
$current_page = 'domestic-verification';
$page_title = 'Verification Required';
include 'layout/header.php';

require_once(ROOT_PATH . "/include/Transfer/DomesticFunction.php");

if (!isset($_SESSION['is_dom_code'])) {
    header("Location:./domestic-transfer.php");
    exit();
}

if (!isset($_SESSION['is_transfer'])) {
    header("Location:./dashboard.php");
}

$error = '';
if (isset($_POST['cot_submit'])) {
    $cotCode = $_POST['cot_code'];
    $acct_cot = $row['acct_cot'];

    if ($cotCode === $acct_cot) {
        if ($page['tax_code'] == '0') {
            $_SESSION['domestic-transfer'] = $user_id;
            $_SESSION['is_tax_code'] = "Cot";
            $_SESSION['is_transfer']  = "transfer";
            header("Location:./dom-code3.php");
            exit();
        } else {
            $_SESSION['domestic-transfer'] = $user_id;
            $_SESSION['is_cot_code'] = "Cot";
            $_SESSION['is_transfer']  = "transfer";
            header("Location:./dom-code2.php");
            exit();
        }
    } else {
        $error = 'Invalid Code';
    }
}
?>

<div class="form-head mb-4">
    <h2 class="text-black font-w600 mb-2">Security Verification</h2>
    <p class="mb-0 text-muted">Complete the verification process to proceed with your transfer</p>
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
                <h3 class="text-primary mb-3">Processing Transfer</h3>
                <p class="text-muted mb-4">Please wait while we secure your transaction</p>

                <div class="loading-progress-container mx-auto" style="max-width: 400px;">
                    <div class="loading-progress-bar" id="loading-progress-bar"></div>
                    <div class="loading-progress-text" id="loading-progress-text">0%</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" id="verificationForm" style="display: none;">
            <div class="card-body text-center py-4">
                <div class="verification-icon mb-4">
                    <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle mx-auto">
                        <i class="fas fa-lock text-success fa-2x"></i>
                    </div>
                </div>
                <h3 class="text-success mb-3">Enter Verification Code</h3>
                <p class="text-muted mb-4">Please enter the 4-digit <?= $page['code1'] ?> code</p>

                <!-- PIN Input Squares -->
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
                <!-- Virtual Keypad -->
                <div class="virtual-keypad">
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="1">1</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="2">2</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="3">3</button>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="4">4</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="5">5</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="6">6</button>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="7">7</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="8">8</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="9">9</button>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad btn-clear w-100 py-3">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad w-100 py-3" data-number="0">0</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-keypad btn-backspace w-100 py-3">
                                <i class="fas fa-backspace"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <form method="POST" id="verificationFormSubmit">
                    <input type="hidden" name="cot_code" id="finalCode">
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
                        <button type="submit" name="cot_submit" class="btn btn-success btn-lg py-3" id="submitBtn"
                            disabled>
                            <i class="fas fa-check-circle me-2"></i>Verify & Continue
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-transparent border-top">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-info"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted">
                            This verification ensures the security of your transfer.
                            Use the secure keypad to enter your code.
                        </small>
                    </div>
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

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-success:disabled {
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

    let progressValue = 0;

    function updateProgressBar() {
        progressBar.style.width = `${progressValue}%`;
        progressText.textContent = `${progressValue}%`;

        if (progressValue === 35) {
            setTimeout(() => {
                progressSection.style.display = 'none';
                verificationForm.style.display = 'block';
                verificationForm.classList.add('fade-in-up');
                initializeKeypad();
            }, 300);
        } else if (progressValue < 35) {
            progressValue++;
            setTimeout(updateProgressBar, 250);
        }
    }

    function initializeKeypad() {
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