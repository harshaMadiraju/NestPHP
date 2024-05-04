<?php

use NestPHP\Common\Application;

require_once "../vendor/autoload.php";


// Create an instance of BaseModule (or your specific module class)
$app = new Application();

// Extract the HTTP method and requested URI
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

// echo $method." yes ";
// echo $path." path ";
// exit;

// Handle the incoming request
$response = $app->handleRequest($method, $path);

// Output the response
echo $response;