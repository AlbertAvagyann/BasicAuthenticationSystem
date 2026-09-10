<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<div style="max-width: 480px; margin: 96px auto 0; padding: 0 24px; text-align: center;">
    <p style="color: var(--error); font-size: 1.05rem;"><?= htmlspecialchars($message) ?></p>
    <p><a href="javascript:history.back()">&larr; Go back</a></p>
</div>

</body>
</html>