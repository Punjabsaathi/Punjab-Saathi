<?php
$secret = 'psk-deploy-secret-2024';
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$payload = file_get_contents('php://input');

if (!hash_equals('sha256=' . hash_hmac('sha256', $payload, $secret), $signature)) {
    http_response_code(403);
    die('Unauthorized');
}

$base = '/home/u143094305/domains/punjabsevakendra.in/public_html';

$output = '';
$output .= shell_exec("cd $base && git fetch origin 2>&1");
$output .= shell_exec("cd $base && git reset --hard origin/main 2>&1");
$output .= shell_exec("cd $base && php artisan config:clear 2>&1");
$output .= shell_exec("cd $base && php artisan cache:clear 2>&1");
$output .= shell_exec("cd $base && php artisan view:clear 2>&1");
$output .= shell_exec("cd $base && php artisan route:clear 2>&1");
$output .= shell_exec("cd $base && php artisan migrate --force 2>&1");

echo "Deployed!\n" . $output;