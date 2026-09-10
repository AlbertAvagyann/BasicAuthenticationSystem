<?php

function renderErrorPage(int $statusCode, string $message): void
{
    http_response_code($statusCode);
    require __DIR__ . '/../views/errors/error_view.php';
    exit;
}