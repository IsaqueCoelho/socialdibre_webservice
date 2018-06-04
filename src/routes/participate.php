<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\Participate;

$app->get('/api/v1/participates[/]', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
});

$app->post('/api/v1/participates[/]', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
    /*
    $data = $request->getParsedBody();
    
    $participate = Participate::create($data);

    return $response->withJson([
        "success" => $participate['success'],
        "code" => 201,
        "data" => $participate['result'],
        "message" => $participate['message']
        ], 201);*/
});

$app->get('/api/v1/participates/{id}', function (Request $request, Response $response, array $args) {
    
    $participates = Participate::get($args['id']);
    
    return $response->withJson([
        "success" => $participates['success'],
        "code" => 200,
        "data" => $participates['result'],
        "message" => $participates['message']
        ], 200);
});

$app->put('/api/v1/participates/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
   // return $response->withJson($team, 201);
});

$app->delete('/api/v1/participates/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
   // return $response->withJson($team, 204);
});