<?php

require_once '../vendor/autoload.php';

use Slim\Slim;

$app = new Slim(array(
    'debug' => true,
    'templates.path' => '../templates',
    'mode' => 'development',
//    'log.writer' => new \My\LogWriter(),
//    'log.level' => \Slim\Log::DEBUG,
//    'log.enabled' => true,
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

\Slim\Route::setDefaultConditions(array(
    'id' => '\d+'
));

$app->get('/', function() {
    echo "Recipes";
});

$app->get('/recipe/:id', function($id) use ($app) {
//    echo "Recipe: $id";
//    echo "<br>";
//    $app->flash('error', 'Login required');
    $app->render('recipe_details.php', ['url' => $app->urlFor('recipe2', ['id' => 999])]);
})->name('recipe2');

$app->post('/recipe/:id', function($id) {
    echo "Recipe updated: $id";
});

$app->run();
