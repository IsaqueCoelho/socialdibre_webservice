<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\Relationship;

$app->get('/api/v1/relationships[/]', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
});

$app->post('/api/v1/relationships[/]', function (Request $request, Response $response, array $args) {
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

$app->get('/api/v1/relationships/{id}', function (Request $request, Response $response, array $args) {
    
    $follower = $request->getHeader("follower");
    $page = $request->getHeader("page");

    $relationships = Relationship::get($args['id'], $follower[0], $page[0]);
    
    return $response->withJson([
        "success" => $relationships['success'],
        "code" => 200,
        "data" => $relationships['result'],
        "message" => $relationships['message']
        ], 200);
});

$app->put('/api/v1/relationships/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
   // return $response->withJson($team, 201);
});

$app->delete('/api/v1/relationships/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
   // return $response->withJson($team, 204);
});