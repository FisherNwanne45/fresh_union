<?php
require_once __DIR__ . '/../config.php';
$current_page = 'referral';
$page_title = 'Referral Program';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

$user_id = userDetails('id');
?>

<div class="page-header">
    <h1 class="page-title">Referral Program</h1>
    <div class="page-actions">
        <button onclick="location.reload();" class="btn btn-outline-secondary">
            <i class="fas fa-refresh"></i> Refresh
        </button>
    </div>
</div>

<div class="settings-section">
    <div class="text-center mb-5">
        <div class="referral-hero mb-4">
            <img src="<?= $web_url ?>/assets/images/ref.png" alt="Referral Program" class="referral-image">
        </div>
        <h2 class="referral-hero-title">Earn Extra Money With Every Referral</h2>
        <p class="referral-hero-description text-muted">Share your referral link with friends and earn rewards when they
            join.</p>
    </div>

    <div class="referral-link-section">
        <h4 class="mb-3">Your Referral Link</h4>
        <div class="input-group input-group-lg">
            <input type="text" class="form-control" id="referralLink"
                value="<?= $web_url ?>/online-account-opening.php?id=<?= $row['acct_no'] ?>" readonly>
            <button class="btn btn-primary" type="button" id="copyReferralBtn">
                <i class="fas fa-copy me-2"></i> Copy
            </button>
        </div>
        <small class="form-text text-muted mt-2">Share this link with your friends to start earning rewards</small>
    </div>
</div>

<div class="settings-section">
    <h3>How It Works</h3>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="how-it-works-item">
                <div class="works-icon bg-primary">
                    <i class="fas fa-share-alt fa-2x"></i>
                </div>
                <h5 class="mt-3">Share Your Link</h5>
                <p class="text-muted">Share your unique referral link with friends and family</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="how-it-works-item">
                <div class="works-icon bg-success">
                    <i class="fas fa-user-plus fa-2x"></i>
                </div>
                <h5 class="mt-3">They Sign Up</h5>
                <p class="text-muted">Your friends sign up using your referral link</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="how-it-works-item">
                <div class="works-icon bg-warning">
                    <i class="fas fa-gift fa-2x"></i>
                </div>
                <h5 class="mt-3">Earn Rewards</h5>
                <p class="text-muted">Get bonuses when your referrals become active users</p>
            </div>
        </div>
    </div>
</div>

<div class="settings-section">
    <h3>Referral Terms & Conditions</h3>

    <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#terms1">
        <div class="setting-info">
            <h4>Eligibility Requirements</h4>
            <p>Who can participate in the referral program</p>
        </div>
        <i class="fas fa-chevron-right"></i>
    </div>
    <div class="collapse" id="terms1">
        <div class="faq-answer p-3 bg-light rounded mt-2">
            <ul>
                <li>You must be an active account holder</li>
                <li>Your account must be in good standing</li>
                <li>Referrals must be new customers</li>
                <li>Each referral must complete account verification</li>
            </ul>
        </div>
    </div>

    <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#terms2">
        <div class="setting-info">
            <h4>Bonus Structure</h4>
            <p>How much you can earn per referral</p>
        </div>
        <i class="fas fa-chevron-right"></i>
    </div>
    <div class="collapse" id="terms2">
        <div class="faq-answer p-3 bg-light rounded mt-2">
            <p>Current referral bonuses:</p>
            <ul>
                <li><strong>Standard Referral:</strong> $10 per active user</li>
                <li><strong>Premium Referral:</strong> $25 for users with initial deposit over $500</li>
                <li><strong>Business Referral:</strong> $50 for business account referrals</li>
            </ul>
            <p class="text-muted mb-0"><small>Bonuses are credited after 30 days of account activity.</small></p>
        </div>
    </div>

    <div class="setting-item" data-bs-toggle="collapse" data-bs-target="#terms3">
        <div class="setting-info">
            <h4>Payment Schedule</h4>
            <p>When you'll receive your referral bonuses</p>
        </div>
        <i class="fas fa-chevron-right"></i>
    </div>
    <div class="collapse" id="terms3">
        <div class="faq-answer p-3 bg-light rounded mt-2">
            <p>Referral bonuses are paid according to the following schedule:</p>
            <ul>
                <li>Bonuses are processed monthly</li>
                <li>Payments are made by the 5th of each month</li>
                <li>Minimum payout: $25</li>
                <li>Bonuses are credited to your main account balance</li>
            </ul>
        </div>
    </div>
</div>

<div class="settings-section">
    <h3>Share Your Link</h3>

    <div class="row text-center">
        <div class="col-md-3 col-6 mb-3">
            <button class="btn btn-outline-primary btn-share w-100" data-platform="whatsapp">
                <i class="fab fa-whatsapp me-2"></i> WhatsApp
            </button>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <button class="btn btn-outline-primary btn-share w-100" data-platform="facebook">
                <i class="fab fa-facebook me-2"></i> Facebook
            </button>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <button class="btn btn-outline-primary btn-share w-100" data-platform="twitter">
                <i class="fab fa-twitter me-2"></i> Twitter
            </button>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <button class="btn btn-outline-primary btn-share w-100" data-platform="email">
                <i class="fas fa-envelope me-2"></i> Email
            </button>
        </div>
    </div>
</div>

<style>
.referral-card {
    border: 1px solid #eaeaea;
    transition: all 0.3s ease;
    height: 100%;
}

.referral-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: var(--primary);
}

.referral-icon {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
}

.referral-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.referral-count {
    font-weight: 700;
}

.referral-description {
    font-size: 0.9rem;
    margin-bottom: 0;
}

.referral-hero {
    padding: 1rem 0;
}

.referral-image {
    max-width: 280px;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.referral-hero-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.referral-hero-description {
    font-size: 1.1rem;
    max-width: 500px;
    margin: 0 auto;
}

.referral-link-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid #eaeaea;
}

.how-it-works-item {
    padding: 1.5rem 1rem;
}

.works-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
}

.btn-share {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-share:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.settings-section {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    border: 1px solid #eaeaea;
}

.settings-section h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f8f9fa;
    font-weight: 700;
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

.setting-info h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
}

.setting-info p {
    margin: 0.25rem 0 0 0;
    font-size: 0.875rem;
    color: #6c757d;
}

.setting-item i {
    color: #6c757d;
    transition: transform 0.3s ease;
}

.faq-answer {
    border-left: 4px solid #007bff;
}

.faq-answer ol,
.faq-answer ul {
    margin-bottom: 1rem;
}

.faq-answer li {
    margin-bottom: 0.5rem;
}

/* Success alert for copy feedback */
.alert-copy {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {

    .referral-icon,
    .works-icon {
        width: 60px;
        height: 60px;
    }

    .referral-icon i,
    .works-icon i {
        font-size: 1.5rem !important;
    }

    .settings-section {
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .setting-item {
        padding: 0.75rem;
    }

    .referral-link-section {
        padding: 1.5rem;
    }

    .referral-image {
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .referral-hero-title {
        font-size: 1.5rem;
    }

    .referral-hero-description {
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const referralLink = document.getElementById('referralLink');
    const copyReferralBtn = document.getElementById('copyReferralBtn');

    // Copy referral link functionality
    copyReferralBtn.addEventListener('click', function() {
        referralLink.select();
        referralLink.setSelectionRange(0, 99999); // For mobile devices

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showCopyFeedback('Link copied to clipboard!', 'success');
                copyReferralBtn.innerHTML = '<i class="fas fa-check me-2"></i> Copied!';
                copyReferralBtn.classList.remove('btn-primary');
                copyReferralBtn.classList.add('btn-success');

                // Reset button after 2 seconds
                setTimeout(() => {
                    copyReferralBtn.innerHTML = '<i class="fas fa-copy me-2"></i> Copy';
                    copyReferralBtn.classList.remove('btn-success');
                    copyReferralBtn.classList.add('btn-primary');
                }, 2000);
            }
        } catch (err) {
            // Fallback for older browsers
            showCopyFeedback('Failed to copy link', 'error');
        }
    });

    // Share buttons functionality
    const shareButtons = document.querySelectorAll('.btn-share');
    shareButtons.forEach(button => {
        button.addEventListener('click', function() {
            const platform = this.getAttribute('data-platform');
            const url = encodeURIComponent(referralLink.value);
            const text = encodeURIComponent('Join me on ' + '<?= WEB_TITLE ?>' +
                '! Use my referral link to sign up.');

            let shareUrl;

            switch (platform) {
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${text}%20${url}`;
                    break;
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?text=${text}&url=${url}`;
                    break;
                case 'email':
                    shareUrl =
                        `mailto:?subject=Join me on <?= WEB_TITLE ?>&body=${text}%0A%0A${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        });
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

    // Show copy feedback
    function showCopyFeedback(message, type) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert-copy');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className =
            `alert alert-${type === 'success' ? 'success' : 'danger'} alert-copy alert-dismissible fade show`;
        alert.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alert);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 3000);
    }

    // Select referral link on click for easy copying
    referralLink.addEventListener('click', function() {
        this.select();
    });
});
</script>

<?php include 'layout/footer.php'; ?>