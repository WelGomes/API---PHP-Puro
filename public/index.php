<?php

use Config\Routes;

require_once "../vendor/autoload.php";
require_once "../config/Routes.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = $_SERVER['REQUEST_METHOD'];

try {
    header('Content-Type: application/json');
    $routes = new Routes();
    
    $returnController = $routes->routes($uri, $request);

    http_response_code(200);
    echo json_encode([
        'sucess' => true,
        'code' => 200,
        'data' => $returnController
    ]);

} catch(Exception $ex) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'code' => 400,
        'error' => $ex->getMessage()
    ]);
}