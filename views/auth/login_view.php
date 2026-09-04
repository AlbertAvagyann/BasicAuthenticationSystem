<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="auth-shell">
    <div class="auth-brand">
        <div class="auth-brand-mark">Basic Auth</div>

        <div>
            <svg class="auth-brand-glyph" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="10" y="20" width="26" height="18" rx="2" stroke="#F7F5F1" stroke-width="2"/>
                <path d="M16 20V14C16 9.58172 19.5817 6 24 6C28.4183 6 32 9.58172 32 14V20" stroke="#F7F5F1" stroke-width="2"/>
                <circle cx="23" cy="28" r="2.5" fill="#F7F5F1"/>
            </svg>
            <div class="auth-brand-copy">
                <h1>Welcome back.</h1>
                <p>Sign in to pick up right where you left off.</p>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Log in</h2>
            <p class="auth-subtitle">Enter your details to continue.</p>

            <?php if (isset($_GET['registered'])): ?>
                <div class="notice notice-success">Registration successful. Please log in.</div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="POST" action="/features/auth/login.php">
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" autocomplete="email">
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password">
                </div>

                <button type="submit" class="btn-primary">Log in</button>
            </form>

            <p class="auth-switch"><a href="/features/password/forgot_password.php">Forgot password?</a></p>
            <p class="auth-switch">Don't have an account? <a href="/features/auth/register.php">Register here</a></p>
        </div>
    </div>
</div>
</body>
</html>