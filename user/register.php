<?php
$page_title = 'Create Account';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinWallet - <?php echo $page_title ?? 'Dashboard'; ?></title>
    <link rel="stylesheet" href="layout/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <div class="auth-container">
        <div class="auth-left">
            <div style="max-width: 400px;">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Join FinWallet</h1>
                <p style="font-size: 1.1rem; opacity: 0.9;">Create your account and start managing your finances
                    today.</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-logo">
                <i class="fas fa-wallet"></i>
                <span>FinWallet</span>
            </div>

            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Sign up to get started with FinWallet</p>

            <form action="dashboard.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control"
                            placeholder="First name" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control"
                            placeholder="Last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email"
                        required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control"
                        placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Create a password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                        placeholder="Confirm your password" required>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" style="margin-top: 0.25rem;">
                        <span>I agree to the <a href="#" style="color: var(--primary);">Terms of Service</a> and <a
                                href="#" style="color: var(--primary);">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Create Account</button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>
        </div>
    </div>

    <script src="layout/script.js"></script>
</body>

</html>