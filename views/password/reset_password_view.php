<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
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
                <h1>Almost done.</h1>
                <p>Choose a new password to finish.</p>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Reset password</h2>

            <?php if ($success): ?>
                <div class="notice notice-success">Your password has been updated.</div>
                <p class="auth-switch"><a href="/features/auth/login.php?reset=1">Go to login</a></p>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($tokenValid): ?>
                    <form method="POST" action="/features/password/reset_password.php">
                        <?= csrfField() ?>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($rawToken) ?>">

                        <div class="field">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" autocomplete="new-password">
                        </div>

                        <div class="field">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn-primary">Reset password</button>
                    </form>
                <?php else: ?>
                    <p class="auth-switch"><a href="/features/password/forgot_password.php">Request a new reset link</a></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>