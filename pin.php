<?php
require_once __DIR__ . '/config.php';
$pageName  = "Pincode";
include(ROOT_PATH . "/auth/header.php");


if (@!$_SESSION['login']) {
  header("Location:./login.php");
}
if (@$_SESSION['acct_no']) {
  header("Location:./users/dashboard.php");
}
$viesConn = "SELECT * FROM users WHERE acct_no = :acct_no";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
  ':acct_no' => $_SESSION['login']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $row['id'];
$fullName = $row['firstname'] . " " . $row['lastname'];
$acct_no = $row['acct_no'];


if (isset($_POST['pincode_submit'])) {
  $pincodeVerified = $_POST['input'];
  $old_otp = $row['acct_pin'];

  // Use a flag to track validation status
  $login_success = false;
  $error_message = '';

  if (empty($pincodeVerified)) {
    $error_message = 'Enter Your Pincode';
  } else if ($pincodeVerified !== $old_otp) {
    $error_message = 'Invalid Pincode';
  } else {
    // Successful Login
    $login_success = true;
  }

  if ($login_success) {
    // Regenerate session ID for security (recommended best practice)
    session_regenerate_id(true);

    $_SESSION['acct_no'] = $acct_no;
    // $_COOKIE['firstVisit'] = $acct_no; // Note: Setting cookies is better done with setcookie() before any output
    header("Location:./user/dashboard.php");
    exit;
  } else {
    // Set session variables for Bootstrap Alert display
    $_SESSION['alert_type'] = 'danger'; // Use 'danger' for error color in Bootstrap
    $_SESSION['alert_message'] = $error_message;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> PIN Verification - <?= $pageName  ?> - <?= $pageTitle ?> </title>
        <meta name="description" content="<?= $pageTitle ?> Mobile Banking">
        <link rel="shortcut icon" href="<?= $web_url ?>/admin/assets/images/logo/<?= $page['favicon'] ?>"
            type="image/x-icon" />
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
        :root {
            --primary-color: #1F1B44;
            --secondary-color: #4A44A6;
            --accent-color: #6C63FF;
            --light-color: #F8F9FA;
            --dark-color: #212529;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .pin-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
            margin: 0 auto;
        }

        .pin-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .pin-body {
            padding: 30px;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 15px;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-account {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .verification-icon {
            margin-bottom: 20px;
        }

        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        .pin-instruction {
            color: var(--dark-color);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .pin-input-container {
            max-width: 280px;
            margin: 0 auto 30px;
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
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.1);
        }

        .pin-input {
            width: 100%;
            height: 100%;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            outline: none;
            caret-color: transparent;
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
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
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
            border-color: #e53e3e;
        }

        .btn-verify {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            height: 50px;
        }

        .btn-verify:hover:not(:disabled) {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-verify:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .security-notice {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid var(--accent-color);
        }

        @media (max-width: 576px) {
            .pin-container {
                margin: 20px;
            }

            .pin-header,
            .pin-body {
                padding: 20px;
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
        </style>
    </head>

    <body>
        <div class="container">
            <div class="pin-container">
                <!-- Header with user info -->
                <div class="pin-header">
                    <div class="user-avatar">
                        <?php
          // PHP LOGIC FOR IMAGE DISPLAY
          $user_image = $row['acct_image'];
          $image_folder = $web_url . "/assets/user/profile/";
          $default_image = "default.png";

          if (!empty($user_image) && file_exists(ROOT_PATH . "/assets/user/profile/" . $user_image)) {
            $image_to_display = $image_folder . $user_image;
          } else {
            $image_to_display = $image_folder . $default_image;
          }
          ?>

                        <img src="<?= $image_to_display ?>" width="40" alt="Profile Image" />

                    </div>
                    <h4 class="user-name"><?= $row['lastname']; ?> <?= $row['firstname']; ?></h4>
                    <div class="user-account">Account: <?= $acct_no ?></div>
                </div>
                <?php
      if (isset($_SESSION['alert_message']) && isset($_SESSION['alert_type'])) {
        // Ensure the type is a valid Bootstrap class (e.g., 'danger')
        $alert_class = htmlspecialchars($_SESSION['alert_type']);
        $alert_text = htmlspecialchars($_SESSION['alert_message']);

        echo '<div class="alert alert-' . $alert_class . ' alert-dismissible fade show mt-4 mb-4" role="alert">';
        echo '<strong>Error:</strong> ' . $alert_text;
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';

        // Clear the session variables after display
        unset($_SESSION['alert_message']);
        unset($_SESSION['alert_type']);
      }
      ?>
                <!-- PIN Verification Body -->
                <div class="pin-body">


                    <h3 class="text-center text-primary mb-3">Enter Your PIN Code</h3>
                    <p class="text-center pin-instruction">Enter your 4-digit security PIN to access your account</p>

                    <!-- PIN Input Squares -->
                    <div class="pin-input-container">
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

                    <!-- Hidden Form for Submission -->
                    <form method="POST" id="pinForm">
                        <input type="hidden" name="input" id="pinCode">

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="pincode_submit" class="btn btn-verify" id="verifyBtn" disabled>
                                <i class="fas fa-shield-check me-2"></i>Verify PIN
                            </button>
                        </div>
                    </form>

                    <!-- Security Notice -->
                    <div class="security-notice">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">
                                    For security reasons, please do not share your PIN with anyone. This PIN is required
                                    to access your account.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pinInputs = document.querySelectorAll('.pin-input');
            const pinCodeInput = document.getElementById('pinCode');
            const verifyBtn = document.getElementById('verifyBtn');
            let currentIndex = 0;

            // Function to update the active pin square
            function updateActiveSquare() {
                pinInputs.forEach((input, index) => {
                    if (index === currentIndex) {
                        input.parentElement.classList.add('active');
                    } else {
                        input.parentElement.classList.remove('active');
                    }
                });
            }

            // Initialize active state
            updateActiveSquare();

            // Number buttons
            document.querySelectorAll('.btn-keypad[data-number]').forEach(button => {
                button.addEventListener('click', function() {
                    if (currentIndex < 4) {
                        const number = this.getAttribute('data-number');
                        pinInputs[currentIndex].value = number;
                        currentIndex++;
                        updateActiveSquare();

                        // Update the hidden input
                        updatePinCode();

                        // Check if all digits are filled
                        if (currentIndex === 4) {
                            verifyBtn.disabled = false;
                        }
                    }
                });
            });

            // Clear button
            document.querySelector('.btn-clear').addEventListener('click', function() {
                pinInputs.forEach(input => {
                    input.value = '';
                });
                currentIndex = 0;
                updateActiveSquare();
                verifyBtn.disabled = true;
                updatePinCode();
            });

            // Backspace button
            document.querySelector('.btn-backspace').addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    pinInputs[currentIndex].value = '';
                    updateActiveSquare();
                    verifyBtn.disabled = true;
                    updatePinCode();
                }
            });

            // Update the hidden pin code input
            function updatePinCode() {
                let code = '';
                pinInputs.forEach(input => {
                    code += input.value;
                });
                pinCodeInput.value = code;
            }

            // Form submission
            document.getElementById('pinForm').addEventListener('submit', function(e) {
                if (pinCodeInput.value.length !== 4) {
                    e.preventDefault();
                    alert('Please enter a complete 4-digit PIN');
                }
            });
        });
        </script>
    </body>

</html>