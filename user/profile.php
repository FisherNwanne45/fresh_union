<?php
require_once __DIR__ . '/../config.php';
$current_page = 'settings';
$page_title = 'Account Settings';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

// Fetch the image names from the database
$user_image = $row['acct_image'];
$user_image2 = $row['acct_image2'];

// Define the path to the images directory
$image_folder = $web_url . "/assets/user/profile/";

// Set the default images
$default_image = "default.png";
$default_image2 = "id.jpg";

// Check if the images exist and are not empty
if (!empty($user_image) && file_exists(ROOT_PATH . "/assets/user/profile/" . $user_image)) {
    $image_to_display = $image_folder . $user_image;
} else {
    $image_to_display = $image_folder . $default_image;
}

if (!empty($user_image2) && file_exists(ROOT_PATH . "/assets/user/profile/" . $user_image2)) {
    $image_to_display2 = $image_folder . $user_image2;
} else {
    $image_to_display2 = $image_folder . $default_image2;
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Account Settings</h2>
    <a href="settings.php" class="btn btn-outline-primary">
        <i class="fas fa-palette me-2"></i>Theme Options
    </a>
</div>

<!-- Profile Header Section -->
<div class="card mb-4">
    <div class="card-body text-center py-5">
        <div class="avatar-section position-relative d-inline-block">
            <img src="<?= $image_to_display ?>" alt="Profile Picture" class="rounded-circle profile-avatar">
            <a href="upload-pics.php" class="avatar-edit-btn">
                <i class="fas fa-camera"></i>
            </a>
        </div>
        <h3 class="mt-3 mb-1"><?= $fullName ?></h3>
        <p class="text-muted">Account Number: <?= $row['acct_no'] ?></p>
        <div class="badge bg-<?= $row['acct_status'] === 'active' ? 'success' : 'danger' ?>">
            <?= ucfirst($row['acct_status']) ?> Account
        </div>
    </div>
</div>

<!-- Profile Settings Section -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-cog me-2 text-primary"></i>
            Profile Settings
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <!-- Edit Profile -->
            <a href="settings-profile.php" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-primary me-3">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Edit Profile Information</h6>
                        <p class="mb-0 text-muted small">Update your personal details and contact information</p>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>

            <!-- Identity Document -->
            <div class="list-group-item">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-info me-3">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Identity Document</h6>
                        <p class="mb-2 text-muted small">Your verified identity document</p>
                        <div class="id-preview-container">
                            <img src="<?= $image_to_display2 ?>" alt="ID Document" class="id-preview img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statements & Reports -->
            <a href="transactions.php" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-warning me-3">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Statements & Reports</h6>
                        <p class="mb-0 text-muted small">Download monthly statements and transaction reports</p>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>

            <!-- Referrals -->
            <a href="ref.php" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-success me-3">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Referral Program</h6>
                        <p class="mb-0 text-muted small">Earn money when your friends join <?= $web_title ?></p>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>

            <!-- Help Center -->
            <a href="support.php" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-danger me-3">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">24/7 Help Center</h6>
                        <p class="mb-0 text-muted small">Have an issue? Speak to our support team</p>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Password & Security Section -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="fas fa-shield-alt me-2 text-success"></i>
            Password & Security
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <!-- Update Password -->
            <a href="settings-password.php" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-success me-3">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Update Password</h6>
                        <p class="mb-0 text-muted small">Change your account login password</p>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>

            <!-- Update Transaction Pin -->
            <a href="settings-pin.php" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-success me-3">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Update Transaction PIN</h6>
                        <p class="mb-0 text-muted small">Change your 4-digit transaction PIN</p>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>

            <!-- Logout -->
            <a href="logout.php" class="list-group-item list-group-item-action text-danger">
                <div class="d-flex align-items-center">
                    <div class="setting-icon bg-danger me-3">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Log Out</h6>
                        <p class="mb-0 text-muted small">Securely sign out of your account</p>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Version Info -->
<div class="text-center mt-4 mb-4">
    <p class="text-muted small"><?= $web_title ?> • Version 9.8.0</p>
</div>

<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .avatar-edit-btn:hover {
        transform: scale(1.1);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
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

    .id-preview {
        max-width: 200px;
        max-height: 120px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Badge styles */
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        .avatar-edit-btn {
            width: 32px;
            height: 32px;
            bottom: 8px;
            right: 8px;
        }

        .card-body {
            padding: 1rem;
        }

        .list-group-item {
            padding: 1rem;
        }

        .setting-icon {
            width: 42px;
            height: 42px;
        }

        .id-preview {
            max-width: 150px;
            max-height: 100px;
        }
    }

    @media (max-width: 576px) {
        .profile-avatar {
            width: 80px;
            height: 80px;
        }

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
        // Add click animation to list items
        const listItems = document.querySelectorAll('.list-group-item-action');
        listItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(102, 126, 234, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
            `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });

    // Add ripple effect animation
    const style = document.createElement('style');
    style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
    document.head.appendChild(style);
</script>

<?php include 'layout/footer.php'; ?>