<?php

// Forward Vercel serverless requests to normal public/index.php
$storagePath = '/tmp/storage';
if (!is_dir($storagePath . '/framework/views')) {
    @mkdir($storagePath . '/framework/views', 0777, true);
    @mkdir($storagePath . '/framework/cache/data', 0777, true);
    @mkdir($storagePath . '/framework/sessions', 0777, true);
    @mkdir($storagePath . '/logs', 0777, true);
}

putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');
putenv('APP_CONFIG_CACHE=' . $storagePath . '/config.php');
putenv('APP_SERVICES_CACHE=' . $storagePath . '/services.php');
putenv('APP_PACKAGES_CACHE=' . $storagePath . '/packages.php');
putenv('APP_ROUTES_CACHE=' . $storagePath . '/routes.php');

require __DIR__ . '/../public/index.php';
