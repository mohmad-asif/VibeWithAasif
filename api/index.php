<?php

// Prepare serverless writable directories in /tmp for Vercel
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
}

require __DIR__ . '/../public/index.php';
