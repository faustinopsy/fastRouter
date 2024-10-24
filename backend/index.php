<?php
namespace Backend\Api;
use Backend\Api\Rotas\Router;
use Backend\Api\Http\HttpHeader;
use Backend\Api\Rotas\AttributeRouter;

require_once '../vendor/autoload.php';

HttpHeader::setDefaultHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}


$router = new AttributeRouter();

$router->passaController(\Backend\Api\Controllers\UserController::class);

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->resolve($method, $uri);
