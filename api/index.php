<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Prepare serverless storage and cache in /tmp
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
    $storagePath . '/app/public',
    $storagePath . '/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Copy production packages.php if available
$srcPackages = __DIR__ . '/../bootstrap/cache/packages.php';
if (file_exists($srcPackages)) {
    @copy($srcPackages, $storagePath . '/framework/cache/packages.php');
}

$cacheVars = [
    'VIEW_COMPILED_PATH' => $storagePath . '/framework/views',
    'APP_STORAGE'        => $storagePath,
    'APP_PACKAGES_CACHE' => $storagePath . '/framework/cache/packages.php',
    'APP_SERVICES_CACHE' => $storagePath . '/framework/cache/services.php',
    'APP_CONFIG_CACHE'   => $storagePath . '/framework/cache/config.php',
    'APP_ROUTES_CACHE'   => $storagePath . '/framework/cache/routes.php',
    'APP_EVENTS_CACHE'   => $storagePath . '/framework/cache/events.php',
];

foreach ($cacheVars as $key => $val) {
    putenv("$key=$val");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

if (!getenv('APP_KEY')) {
    putenv('APP_KEY=base64:Xvymu8Aa4RjuA/40T6aD6K7RjdRax0nP639dt82pcDg=');
    $_ENV['APP_KEY'] = 'base64:Xvymu8Aa4RjuA/40T6aD6K7RjdRax0nP639dt82pcDg=';
    $_SERVER['APP_KEY'] = 'base64:Xvymu8Aa4RjuA/40T6aD6K7RjdRax0nP639dt82pcDg=';
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
    $_SERVER['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_DATABASE'] = $sqliteDb;
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
