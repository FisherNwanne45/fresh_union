<?php
require_once __DIR__ . '/../config.php';
$current_page = 'support';
$page_title = 'Create Support Ticket';
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

if (isset($_POST['ticket-submit'])) {
    $ticket_message = $_POST['ticket_message'];

    if (empty($ticket_message)) {
        $_SESSION['error_message'] = "Ticket Message Required!";
    } else {
        $sql = "INSERT INTO ticket (user_id,ticket_message) VALUES(:user_id,:ticket_message)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'user_id' => $user_id,
            'ticket_message' => $ticket_message
        ]);

        $full_name = $row['firstname'] . " " . $row['lastname'];
        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $SITE_ADDRESS = $page['url_address'];
        $user_email = $row['acct_email'];
        $user_acctno = $row['acct_no'];
        $ticket_status = "Opened";
        $message = $sendMail->TicketMsg($full_name, $user_acctno, $ticket_message, $ticket_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);

        $subject = "Ticket" . "-" . $APP_NAME;
        $email_message->send_mail($user_email, $message, $subject);

        $_SESSION['success_message'] = 'Your ticket has been submitted successfully!';
    }

    header("Location: ticket.php"); // Redirect to avoid form resubmission
    exit();
}

?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Create Support Ticket</h2>
    <button class="btn btn-primary" onclick="location.reload();">
        <i class="fas fa-refresh me-2"></i>Refresh
    </button>
</div>
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php unset($_SESSION['success_message']);
endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $_SESSION['error_message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php unset($_SESSION['error_message']);
endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-10 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Create New Support Ticket
                </h4>
            </div>
            <div class="card-body">
                <!-- Information Alert -->
                <div class="alert alert-info">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading">Need Help?</h6>
                            <p class="mb-0">Fill out the form below to contact our support team. We'll get back to you
                                as soon as possible.</p>
                        </div>
                    </div>
                </div>

                <form method="post" class="needs-validation" novalidate>
                    <!-- User Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-label">Account Holder</h6>
                                <p class="info-value"><?= $fullName ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-label">Account Number</h6>
                                <p class="info-value"><?= $row['acct_no'] ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= $row['acct_email'] ?>" disabled>
                        </div>
                        <div class="form-text">
                            This is the email address associated with your account. Support responses will be sent here.
                        </div>
                    </div>

                    <!-- Message Field -->
                    <div class="mb-4">
                        <label for="ticket_message" class="form-label">
                            Message <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="ticket_message" name="ticket_message" rows="6"
                            placeholder="Please describe your issue in detail..." required></textarea>
                        <div class="form-text">
                            Be as detailed as possible to help us resolve your issue quickly.
                        </div>
                        <div class="invalid-feedback">
                            Please provide a detailed description of your issue.
                        </div>
                    </div>

                    <!-- Common Issues Quick Links -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Common Issues</h6>
                        <div class="row g-2">
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 quick-issue"
                                    data-issue="I'm having trouble with a transaction">
                                    <i class="fas fa-exchange-alt me-1"></i>Transaction Issue
                                </button>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 quick-issue"
                                    data-issue="I forgot my transaction pin">
                                    <i class="fas fa-key me-1"></i>Forgot PIN
                                </button>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 quick-issue"
                                    data-issue="I need help with my account verification">
                                    <i class="fas fa-user-check me-1"></i>Account Verification
                                </button>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 quick-issue"
                                    data-issue="I'm having issues with deposits">
                                    <i class="fas fa-money-bill-wave me-1"></i>Deposit Problem
                                </button>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 quick-issue"
                                    data-issue="I'm having issues with withdrawals">
                                    <i class="fas fa-hand-holding-usd me-1"></i>Withdrawal Problem
                                </button>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 quick-issue"
                                    data-issue="I need to update my account information">
                                    <i class="fas fa-user-edit me-1"></i>Update Account Info
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" name="ticket-submit">
                            <i class="fas fa-paper-plane me-2"></i>Create Support Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Support Information Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-headset me-2 text-primary"></i>
                    Support Information
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="support-info">
                            <h6><i class="fas fa-clock me-2 text-warning"></i>Response Time</h6>
                            <p class="text-muted">Typically within 24 hours</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="support-info">
                            <h6><i class="fas fa-envelope me-2 text-info"></i>Email Support</h6>
                            <p class="text-muted"><?= $page['url_email'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <h6><i class="fas fa-lightbulb me-2 text-success"></i>Tips for Faster Resolution</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Include relevant transaction IDs or reference numbers
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Describe the steps you've already taken
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Attach screenshots if applicable (you can reply to the support email)
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Check our FAQ section for quick answers
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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
        border-left: 4px solid var(--info);
    }

    .info-card {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .info-value {
        font-size: 1rem;
        color: #2c3e50;
        margin: 0;
        font-weight: 500;
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
        color: #6c757d;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
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

    .quick-issue {
        font-size: 0.8rem;
        padding: 0.5rem;
    }

    .quick-issue:hover {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .support-info {
        margin-bottom: 1rem;
    }

    .support-info h6 {
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        color: #495057;
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

        .quick-issue {
            font-size: 0.75rem;
            padding: 0.4rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        'use strict';

        // Bootstrap form validation
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Quick issue buttons
        const quickIssueButtons = document.querySelectorAll('.quick-issue');
        const messageTextarea = document.getElementById('ticket_message');

        quickIssueButtons.forEach(button => {
            button.addEventListener('click', function() {
                const issueText = this.getAttribute('data-issue');

                // If textarea is empty, set the value, otherwise append
                if (!messageTextarea.value.trim()) {
                    messageTextarea.value = issueText;
                } else {
                    messageTextarea.value += '\n\n' + issueText;
                }

                // Focus on textarea and scroll to it
                messageTextarea.focus();
                messageTextarea.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Show temporary feedback on the button
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check me-1"></i>Added!';
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);
            });
        });

        // Auto-expand textarea as user types
        messageTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
</script>

<?php include 'layout/footer.php'; ?>