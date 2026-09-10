<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
                <h1>Create your account.</h1>
                <p>Takes less than a minute to get started.</p>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Register</h2>
            <p class="auth-subtitle">Fill in your details below.</p>

            <?php if (!empty($errors)): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="POST" action="/features/auth/register.php">
                <?= csrfField() ?>
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" autocomplete="name">
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" autocomplete="email">
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="new-password">
                </div>

                <button type="submit" class="btn-primary">Create account</button>
            </form>

            <p class="auth-switch">Already have an account? <a href="/features/auth/login.php">Log in here</a></p>
        </div>
    </div>
</div>
</body>
</html>