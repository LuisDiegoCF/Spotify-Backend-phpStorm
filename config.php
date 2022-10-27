<?php
// permite guardar variables de session
session_start();

// para usar el composer
include_once "vendor/autoload.php";
$username = "root";
$password = "root";
$hostname = "localhost";
$port = 3306;
$dbname = "spotify";

// para hacer que el contenido que se envia sea json
header('Content-Type: application/json; charset=utf-8');

// enable cors
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}