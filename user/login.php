<?php
$page_title = 'Login';
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
                    <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Welcome to FinWallet</h1>
                    <p style="font-size: 1.1rem; opacity: 0.9;">Manage your finances with our secure and easy-to-use
                        digital
                        wallet.</p>
                </div>
            </div>

            <div class="auth-right">
                <div class="auth-logo">
                    <i class="fas fa-wallet"></i>
                    <span>FinWallet</span>
                </div>

                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your account to continue</p>

                <form action="dashboard.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter your password" required>
                    </div>

                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox">
                            <span>Remember me</span>
                        </label>

                        <a href="#" style="color: var(--primary); text-decoration: none;">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>

                <div class="auth-footer">
                    Don't have an account? <a href="register.php">Sign up here</a>
                </div>
            </div>
        </div>
        <script src="layout/script.js"></script>
    </body>

</html>