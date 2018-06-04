<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//Exceptions
$container['errorHandler'] = function ($c){
    return function($request, $response, $exception) use ($c){
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        return $c['response']->withStatus($statusCode)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson([
                    "success" => 0,
                    "code" => $statusCode,
                    "message" => $exception->getMessage()
                    ], $statusCode);
    };
};

$container['notAllowedHandler'] = function ($c){
    return function ($request, $response, $methods) use ($c){
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(',', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader('Access-Control-Allow-Methods', implode(',', $methods))
            ->withJson([
                    "success" => 0,
                    "code" => 405,
                    "message" => "Método não permitido; Métodos validos: " . implode(', ', $methods)
                    ], 405);
    };
};

$container['notFoundHandler'] = function ($c){
    return function ($request, $response) use ($c){
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson([
                "success" => 0,
                "code" => 404,
                "message" => "API não encontrada"
                ], 404);
    };
};