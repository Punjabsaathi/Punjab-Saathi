<?php
// deploy.php — place in public_html root

// Secret check - GitHub will send this in the webhook payload
$secret = 'CHANGE-THIS-TO-A-LONG-RANDOM-STRING';

$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$payload = file_get_contents('php://input');
$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    exit('Forbidden');
}

// Only deploy on push to main
$data = json_decode($payload, true);
if (($data['ref'] ?? '') !== 'refs/heads/main') {
    exit('Not main branch, skipping');
}

header('Content-Type: text/plain');
$log = [];

function run($cmd, &$log) {
    $output = shell_exec($cmd . ' 2>&1');
    $log[] = "$ $cmd\n$output";
}

run('git fetch origin', $log);
run('git reset --hard origin/main', $log);
run('git clean -fd -e .htaccess -e deploy.php', $log);
run('composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs', $log);
run('php artisan migrate --force', $log);
run('php artisan optimize:clear', $log);
run('php artisan config:cache', $log);
run('php artisan route:cache', $log);
run('php artisan view:cache', $log);

if (function_exists('opcache_reset')) {
    opcache_reset();
    $log[] = 'OPcache cleared';
}

$log[] = "Deployment finished at " . date('Y-m-d H:i:s');

echo implode("\n\n", $log);