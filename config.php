<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the host (domain)
$host = $_SERVER['HTTP_HOST'];

// Construct the origin
$origin = $protocol . $host;

// define('__ROOT_DIR__', $origin);
define('__ROOT_DIR__', '/homework');

?>