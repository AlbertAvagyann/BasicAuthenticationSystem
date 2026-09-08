<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify your email</title>
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
                <h1>Almost there.</h1>
                <p>Confirm your email to unlock your dashboard.</p>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Verify your email</h2>
            <p class="auth-subtitle">We sent a verification link to <?= htmlspecialchars($user['email']) ?>.</p>

            <?php if ($resent): ?>
                <div class="notice notice-success">A new verification email has been sent.</div>
            <?php endif; ?>

            <form method="POST" action="/features/verification/send_verification.php">
                <?= csrfField() ?>
                <button type="submit" class="btn-primary">Resend verification email</button>
            </form>

            <p class="auth-switch"><a href="/features/auth/logout.php">Log out</a></p>
        </div>
    </div>
</div>
</body>
</html>