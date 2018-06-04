<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\User;

$app->get('/api/v1/users[/]', function (Request $request, Response $response, array $args) {
    

    $page = $request->getHeader("page");

    $number_page = (int) $page[0];

    $users = User::getAll($number_page);
    
    return $response->withJson([
        "success" => $users['success'],
        "code" => 200,
        "page" => $users['page'],
        "data" => $users['result'],
        "message" => $users['message']
        ], 200);

});

$app->post('/api/v1/users', function (Request $request, Response $response, array $args) {

    throw new \Exception("Ação não permitida!", 405);
    
    /*
    $data = $request->getParsedBody();
    
    $user = User::create($data);

    return $response->withJson([
        "success" => $user['success'],
        "operation_code" => $user['operation_code'],
        "code" => 201,
        "data" => $user['result'],
        "message" => $user['message']
        ], 201);*/
});

$app->get('/api/v1/users/{id}', function (Request $request, Response $response, array $args) {
    
    $user = User::get($args['id']);
    
    return $response->withJson([
        "success" => $user['success'],
        "code" => 200,
        "data" => $user['result'],
        "message" => $user['message']
        ], 200);
});

$app->put('/api/v1/users/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
    //return $response->withJson($user, 201);
});

$app->delete('/api/v1/users/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
    //return $response->withJson($user, 204);
});