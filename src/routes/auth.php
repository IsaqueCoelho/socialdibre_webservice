<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

use App\Controllers\User;

$app->post('/api/v1/auth/login', function (Request $request, Response $response, array $args) {
    
    $data = $request->getParsedBody();
    
    $user = User::login($data);

    $return_data = array();

    if($user['success'] == 1){

        $key = $this->get('settings')['secretKey'];

        $return_data = ["id" => $user['result'], "token" => JWT::encode(["id" => $user['result']], $key)];

    }

    return $response->withJson([
        "success" => $user['success'],
        "code" => 200,
        "data" => $return_data,
        "message" => $user['message']
        ], 200);
    
});

$app->post('/api/v1/auth/register', function (Request $request, Response $response, array $args) {
    
    $data = $request->getParsedBody();
    
    $user = User::create($data);

    $return_data = array();

    if($user['success'] == 1){

        $key = $this->get('settings')['secretKey'];

        $return_data = ["id" => $user['result'], "token" => JWT::encode(["id" => $user['result']], $key)];

    }

    return $response->withJson([
        "success" => $user['success'],
        "operation_code" => $user['operation_code'],
        "code" => 201,
        "data" => $return_data,
        "message" => $user['message']
        ], 201);
});

