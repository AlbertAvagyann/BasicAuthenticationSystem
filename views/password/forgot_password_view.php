<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>
<button id="theme-toggle" class="theme-toggle" type="button" aria-label="Toggle dark mode">
    <span class="icon-light">🌙</span>
    <span class="icon-dark">☀️</span>
</button>
<div class="auth-shell">
    <div class="auth-brand">
        <div class="auth-brand-mark">Basic Auth</div>

        <div>
            <svg class="auth-brand-glyph" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="10" y="20" width="26" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                <path d="M16 20V14C16 9.58172 19.5817 6 24 6C28.4183 6 32 9.58172 32 14V20" stroke="currentColor" stroke-width="2"/>
                <circle cx="23" cy="28" r="2.5" fill="currentColor"/>
            </svg>
            <div class="auth-brand-copy">
                <h1>Forgot something?</h1>
                <p>We'll send you a link to reset it.</p>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Forgot password</h2>
            <p class="auth-subtitle">Enter your email and we'll send you a reset link.</p>

            <?php if ($submitted): ?>
                <div class="notice notice-success">If an account with that email exists, we've sent a password reset link to it.</div>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form method="POST" action="/features/password/forgot_password.php">
                    <?= csrfField() ?>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" autocomplete="email">
                    </div>

                    <button type="submit" class="btn-primary">Send reset link</button>
                </form>
            <?php endif; ?>

            <p class="auth-switch"><a href="/features/auth/login.php">Back to login</a></p>
        </div>
    </div>
</div>
</body>
</html>