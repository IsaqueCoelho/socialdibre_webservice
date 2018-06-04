<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

require __DIR__ . '/routes/auth.php';
require __DIR__ . '/routes/user.php';
require __DIR__ . '/routes/team.php';
require __DIR__ . '/routes/participate.php';
require __DIR__ . '/routes/relationship.php';