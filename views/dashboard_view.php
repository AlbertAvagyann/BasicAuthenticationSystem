<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="dash-shell">
    <header class="dash-header">
        <div class="dash-mark">Basic Auth</div>
        <form method="POST" action="logout.php">
            <button type="submit" class="btn-ghost">Log out</button>
        </form>
    </header>

    <main class="dash-main">
        <div class="dash-content">
            <h1>Welcome, <em><?= htmlspecialchars($user['name']) ?></em>.</h1>

            <div class="dash-facts">
                <div class="dash-fact">
                    <span class="dash-fact-label">ID</span>
                    <span class="dash-fact-value"><?= htmlspecialchars($user['id']) ?></span>
                </div>
                <div class="dash-fact">
                    <span class="dash-fact-label">Name</span>
                    <span class="dash-fact-value"><?= htmlspecialchars($user['name']) ?></span>
                </div>
                <div class="dash-fact">
                    <span class="dash-fact-label">Email</span>
                    <span class="dash-fact-value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="dash-fact">
                    <span class="dash-fact-label">Member since</span>
                    <span class="dash-fact-value"><?= htmlspecialchars($user['created_at']) ?></span>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>