<?php
require_once __DIR__ . '/../config.php';
$current_page = 'settings-profile';
$page_title = 'Edit Profile';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

// Handle profile updates
if (isset($_POST['update_profile'])) {
    $phone_number = inputValidation($_POST['phone_number']);
    $acct_address = inputValidation($_POST['acct_address']);
    $state = inputValidation($_POST['state']);
    $zipcode = inputValidation($_POST['zipcode']);

    // Validate inputs
    if (empty($phone_number) || empty($acct_address) || empty($state) || empty($zipcode)) {
        $_SESSION['error_message'] = 'Please fill in all required fields';
    } else {
        // Update profile in database
        $sql = "UPDATE users SET acct_phone = :phone, acct_address = :address, state = :state, zipcode = :zipcode WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            'phone' => $phone_number,
            'address' => $acct_address,
            'state' => $state,
            'zipcode' => $zipcode,
            'id' => $user_id
        ]);

        if ($result) {
            $_SESSION['success_message'] = 'Profile updated successfully!';
            // Refresh user data
            $row = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $row->execute([$user_id]);
            $row = $row->fetch(PDO::FETCH_ASSOC);
        } else {
            $_SESSION['error_message'] = 'Failed to update profile. Please try again.';
        }
    }
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Edit Profile</h2>
    <button type="submit" form="profileForm" class="btn btn-primary">
        <i class="fas fa-save me-2"></i>Save Changes
    </button>
</div>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success solid alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger solid alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $_SESSION['error_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <!-- Personal Information Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    Personal Information
                </h4>
            </div>
            <div class="card-body">
                <form id="profileForm" action="#" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($fullName) ?>"
                                    disabled>
                                <small class="form-text text-muted">Contact support to change your name</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control"
                                    value="<?= htmlspecialchars($row['acct_email']) ?>" disabled>
                                <small class="form-text text-muted">Primary email address</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" class="form-control" name="phone_number"
                                    value="<?= htmlspecialchars($row['acct_phone']) ?>"
                                    placeholder="Enter your phone number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($row['acct_dob']) ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($row['acct_gender']) ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Joined Date</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($row['createdAt']) ?>" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Address Information Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-home me-2 text-primary"></i>
                    Address Information
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Home Address *</label>
                            <input type="text" class="form-control" name="acct_address"
                                value="<?= htmlspecialchars($row['acct_address']) ?>"
                                placeholder="Enter your home address" required form="profileForm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label class="form-label">State *</label>
                            <input type="text" class="form-control" name="state"
                                value="<?= htmlspecialchars($row['state']) ?>" placeholder="State" required
                                form="profileForm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label class="form-label">Zipcode *</label>
                            <input type="text" class="form-control" name="zipcode"
                                value="<?= htmlspecialchars($row['zipcode']) ?>" placeholder="Zipcode" required
                                form="profileForm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Security Card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                    Account Security
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="settings-pin.php" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon bg-primary me-3">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Change Transaction PIN</h6>
                                <p class="mb-0 text-muted small">Update your 4-digit security PIN</p>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="settings-password.php" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <div class="setting-icon bg-success me-3">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Change Password</h6>
                                <p class="mb-0 text-muted small">Update your account password</p>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control:disabled {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
    }

    .form-text {
        font-size: 0.875rem;
    }

    .card {
        border: none;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }

    .card-header {
        background: white;
        border-bottom: 1px solid #eaeaea;
        padding: 1.25rem 1.5rem;
        border-radius: 12px 12px 0 0 !important;
    }

    .card-header .card-title {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .list-group-item {
        border: none;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.3s ease;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .list-group-item-action {
        cursor: pointer;
    }

    .setting-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .setting-icon i {
        font-size: 1.1rem;
    }

    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .list-group-item {
            padding: 1rem;
        }

        .setting-icon {
            width: 42px;
            height: 42px;
        }
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 1rem;
        }

        .list-group-item {
            padding: 0.875rem;
        }

        .setting-icon {
            width: 38px;
            height: 38px;
            margin-right: 0.875rem !important;
        }

        .setting-icon i {
            font-size: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                }
            }, 5000);
        });
    });
</script>

<input type="hidden" name="update_profile" value="1" form="profileForm">

<?php include 'layout/footer.php'; ?>