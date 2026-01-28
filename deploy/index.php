<?php

/**
 * LARAVEL SHARED HOSTING BOOTSTRAP
 * ================================
 * 
 * This file should be placed in public_html/ when Laravel is installed
 * in a subfolder (e.g., /home/user/simardas/)
 * 
 * Structure:
 * /home/simardas/
 * ├── public_html/        ← Domain root (place this file here)
 * │   ├── index.php       ← THIS FILE
 * │   ├── .htaccess       ← Copy from deploy/.htaccess_public_html
 * │   ├── images/         ← SYMLINK or COPY from simardas/public/images
 * │   ├── build/          ← SYMLINK or COPY from simardas/public/build
 * │   └── storage/        ← SYMLINK to simardas/storage/app/public
 * └── simardas/           ← Laravel project root
 *     ├── app/
 *     ├── bootstrap/
 *     ├── storage/
 *     └── vendor/
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path to Laravel project (adjust if needed)
$laravelPath = dirname(__DIR__) . '/simardas';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $laravelPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $laravelPath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $laravelPath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
