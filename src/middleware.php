<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \Slim\Middleware\JwtAuthentication([
    'regexp' => '/(.*)/',
    'header' => 'Authorization',
    'path' => '/api',
    'passthrough' => ['/api/v1/auth/'],
    'secure' => false,
    'realm' => 'Protected',
    'secret' => $container['settings']['secretKey'],
    'error' => function ($request, $response, $arguments) {
        return $response->withHeader('Content-Type', 'Application/json')
        ->withJson([
            "success" => 0,
            "code" => 401,
            "message" => "Falha na Autorização!"
            ], 401);
    }
]));

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization, Origin, Accept')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
