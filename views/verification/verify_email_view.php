<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>
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
                <h1>Email verification.</h1>
                <p>One click and you're all set.</p>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Email Verification</h2>

            <?php if ($status === 'success'): ?>
                <div class="notice notice-success"><?= htmlspecialchars($message) ?></div>
                <p class="auth-switch"><a href="/features/auth/login.php?verified=1">Go to login</a></p>
            <?php elseif ($status === 'expired'): ?>
                <ul class="error-list"><li><?= htmlspecialchars($message) ?></li></ul>
                <p class="auth-switch"><a href="/features/auth/login.php">Log in and resend from there</a></p>
            <?php else: ?>
                <ul class="error-list"><li><?= htmlspecialchars($message) ?></li></ul>
                <p class="auth-switch"><a href="/features/auth/login.php">Back to login</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>