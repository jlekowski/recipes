<?php

require_once '../vendor/autoload.php';

use Slim\Slim;

$app = new Slim(array(
    'debug' => true,
    'templates.path' => '../templates',
    'mode' => 'development',
//    'log.writer' => new \My\LogWriter(),
//    'log.level' => \Slim\Log::DEBUG,
    'log.enabled' => true,
//    'view' => new \My\View(),
    ''
));

//$app->setName('recipes');
//$app->get('/foo', function () use ($app) {
//    $app->render('foo.php'); // <-- SUCCESS
//});

//// Only invoked if mode is "production"
//$app->configureMode('production', function () use ($app) {
//    $app->config(array(
//        'log.enable' => true,
//        'debug' => false
//    ));
//});
//
//// Only invoked if mode is "development"
//$app->configureMode('development', function () use ($app) {
//    $app->config(array(
//        'log.enable' => false,
//        'debug' => true
//    ));
//});

//$app->error(function (\Exception $e) use ($app) {
//    exit('errorek');
//});

\Slim\Route::setDefaultConditions(array(
    'id' => '\d+'
));

$app->get('/', function() use ($app) {
    $app->render('recipes.php');
});

$app->get('/ingredients', function() use ($app) {
    $app->render('ingredients.php');
});

$app->post('/ingredients', function() use ($app) {
    $request = $app->request;
    echo "<pre>" . print_r($request->post(), 1);
    exit;
//    $body = $request->post();
//    $app->response->headers->set('Content-Type', "application/json");
//    $app->response->setBody(json_encode($body));

    $oDB = new PDO("sqlite:../db/recipes.sqlite");
    $stm = $oDB->prepare("INSERT INTO ingredient VALUES (NULL, ?, ?, ?, ?)");
    $stm->execute([$request->post('name'), $request->post('unit'), $request->post('calories'), time()]);

    $app->response->setStatus(201);
});

$app->delete('/ingredients/:id', function($id) use ($app) {
    $oDB = new PDO("sqlite:../db/recipes.sqlite");
    $stm = $oDB->prepare("DELETE FROM ingredient WHERE id = ?");
    $stm->execute([$id]);

    $app->response->setStatus(200);
});

$app->get('/recipe/:id', function($id) use ($app) {
//    echo "Recipe: $id";
//    echo "<br>";
//    $app->flash('error', 'Login required');
    $app->render('recipe_details.php', ['id' => $id, 'url' => $app->urlFor('recipe2', ['id' => $id])]);
})->name('recipe2');

$app->post('/recipe/:id', function($id) {
    echo "Recipe updated: $id";
});

$app->run();
