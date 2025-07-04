<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
