<?php
/**
 * Vercel Entry Point for Laravel
 * Proxies requests to the Laravel application.
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

echo "Hello from Vercel-PHP! If you see this, Laravel is crashing. If you don't see this, Vercel-PHP is crashing.";
exit;

require __DIR__ . '/../public/index.php';
