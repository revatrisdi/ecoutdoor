<?php
/**
 * Vercel Entry Point for Laravel
 * Handles Read-Only file system limitations
 */

// 1. Create temporary storage directories
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    mkdir($storagePath.'/framework/cache/data', 0777, true);
    mkdir($storagePath.'/framework/views', 0777, true);
    mkdir($storagePath.'/framework/sessions', 0777, true);
    mkdir($storagePath.'/logs', 0777, true);
}

// 2. Load Composer
require __DIR__.'/../vendor/autoload.php';

// 3. Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// 4. Override Storage Path to /tmp
$app->useStoragePath($storagePath);

// 5. Handle Request
$app->handleRequest(Illuminate\Http\Request::capture());
