<?php
/**
 * Vercel Entry Point for Laravel
 * Proxies requests to the Laravel application.
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/../public/index.php')) {
    echo "HUGE DISCOVERY: The file public/index.php is MISSING in this Vercel Serverless Function! This means Vercel didn't bundle the rest of the project.";
    exit;
} else {
    echo "The file public/index.php EXISTS! The crash is happening inside Laravel.";
    exit;
}

require __DIR__ . '/../public/index.php';
