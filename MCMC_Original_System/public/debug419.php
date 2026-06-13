<?php
define("LARAVEL_START", microtime(true));
require dirname(__DIR__)."/vendor/autoload.php";
$app = require_once dirname(__DIR__)."/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();

echo "<pre>";
echo "SESSION_DRIVER: " . config("session.driver") . "\n";
echo "SESSION_DOMAIN: [" . config("session.domain") . "]\n";
echo "SESSION_PATH: " . config("session.path") . "\n";
echo "APP_KEY exists: " . (config("app.key") ? "YES" : "NO") . "\n";
echo "DB: " . config("database.default") . "\n";
echo "Bootstrap app.php modified: " . date("Y-m-d H:i:s", filemtime(dirname(__DIR__)."/bootstrap/app.php")) . "\n";
echo ".env modified: " . date("Y-m-d H:i:s", filemtime(dirname(__DIR__)."/.env")) . "\n";
echo "storage/framework/sessions writable: " . (is_writable(dirname(__DIR__)."/storage/framework/sessions") ? "YES" : "NO") . "\n";
echo "</pre>";
