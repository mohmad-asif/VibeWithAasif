<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Prepare serverless storage in /tmp
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
    $storagePath . '/app/public',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');
putenv('APP_STORAGE=' . $storagePath);

if (!getenv('APP_KEY')) {
    putenv('APP_KEY=base64:Xvymu8Aa4RjuA/40T6aD6K7RjdRax0nP639dt82pcDg=');
    $_ENV['APP_KEY'] = 'base64:Xvymu8Aa4RjuA/40T6aD6K7RjdRax0nP639dt82pcDg=';
}

// Fallback SQLite database in /tmp if MySQL is unreachable or not configured
if (!getenv('DB_CONNECTION') || getenv('DB_CONNECTION') === 'sqlite' || (!getenv('DB_HOST') && !getenv('DATABASE_URL'))) {
    $sqliteDb = '/tmp/database.sqlite';
    if (!file_exists($sqliteDb)) {
        @touch($sqliteDb);
    }
    putenv('DB_CONNECTION=sqlite');
    putenv('DB_DATABASE=' . $sqliteDb);
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $sqliteDb;
}

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<div style="font-family:sans-serif;padding:30px;background:#fff1f2;color:#9f1239;border-radius:12px;margin:20px;border:1px solid #fecdd3;">';
    echo '<h2 style="margin-top:0;">Server Exception</h2>';
    echo '<p style="font-size:16px;"><strong>' . htmlspecialchars($e->getMessage()) . '</strong></p>';
    echo '<p style="color:#64748b;font-size:14px;">File: ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>';
    echo '<pre style="background:#881337;color:#ffe4e6;padding:15px;border-radius:8px;overflow:auto;font-size:12px;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</div>';
}
