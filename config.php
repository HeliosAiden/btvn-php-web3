<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the host (domain)
$host = $_SERVER['HTTP_HOST'];

// Construct the origin
$origin = $protocol . $host;

define('__ROOT_URL__', $origin);
// define('__ROOT_DIR__', $_SERVER['DOCUMENT_ROOT']);
define('__ROOT_DIR__', '/homework');
define('__ROOT_CORE__', __ROOT_DIR__ . '/core');

$config['database'] = [
    'host' => 'localhost',
    'db' => 'b5_mydb',
    'user' => 'user',
    'password' => 'my_secret_password'
];

$GLOBALS['database'] = $config['database'];
$GLOBALS['root_core'] = __ROOT_CORE__;
$GLOBALS['root_dir'] = __ROOT_DIR__;
$GLOBALS['root_url'] = __ROOT_URL__;

?>