<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\Team;

$app->get('/api/v1/teams[/]', function (Request $request, Response $response, array $args) {

    $page = $request->getHeader("page");

    $number_page = (int) $page[0];

    $teams = Team::getAll($number_page);
    
    return $response->withJson([
        "success" => $teams['success'],
        "code" => 200,
        "page" => $teams['page'],
        "data" => $teams['result'],
        "message" => $teams['message']
        ], 200);

});

$app->post('/api/v1/teams[/]', function (Request $request, Response $response, array $args) {
    
    $data = $request->getParsedBody();
    
    $team = Team::create($data);

    return $response->withJson([
        "success" => $team['success'],
        "code" => 201,
        "data" => $team['result'],
        "message" => $team['message']
        ], 201);
});

$app->get('/api/v1/teams/{id}', function (Request $request, Response $response, array $args) {
    
    $team = Team::get($args['id']);
    
    return $response->withJson([
        "success" => $team['success'],
        "code" => 200,
        "data" => $team['result'],
        "message" => $team['message']
        ], 200);
});

$app->put('/api/v1/teams/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
    //return $response->withJson($team, 201);
});

$app->delete('/api/v1/teams/{id}', function (Request $request, Response $response, array $args) {
    throw new \Exception("Ação não permitida!", 405);
    //return $response->withJson($team, 204);
});