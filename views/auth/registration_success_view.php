<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Successful</title>
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
            <svg class="auth-brand-glyph"
                 viewBox="0 0 46 46"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <rect
                        x="10"
                        y="20"
                        width="26"
                        height="18"
                        rx="2"
                        stroke="currentColor"
                        stroke-width="2"
                />

                <path
                        d="M16 20V14C16 9.58172 19.5817 6 24 6C28.4183 6 32 9.58172 32 14V20"
                        stroke="currentColor"
                        stroke-width="2"
                />

                <circle
                        cx="23"
                        cy="28"
                        r="2.5"
                        fill="currentColor"
                />

            </svg>

            <div class="auth-brand-copy">
                <h1>Almost there.</h1>
                <p>One quick step before you continue.</p>
            </div>
        </div>

    </div>


    <div class="auth-form-side">

        <div class="auth-form-wrap">

            <h2>Registration successful</h2>

            <p class="auth-subtitle">
                Your account has been created.
            </p>

            <p class="auth-subtitle">
                Please verify your email before logging in.
            </p>


            <?php if (isset($_GET['sent'])): ?>

                <div class="notice notice-success">
                    Verification email has been sent.
                </div>

            <?php endif; ?>


            <form action="/features/verification/send_verification.php" method="POST">
                <?= csrfField() ?>

                <button type="submit" class="btn-primary">
                    Send verification email
                </button>

            </form>


            <p class="auth-switch">
                <a href="/features/auth/login.php">Go to Login</a>
            </p>

        </div>

    </div>

</div>

</body>
</html>