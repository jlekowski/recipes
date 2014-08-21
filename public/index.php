<?php

require_once '../config/config.php';
require_once '../vendor/autoload.php';

use Slim\Slim;
use Slim\Route;
use Recipes\Ingredient;
use Recipes\Recipe;
use Recipes\RecipeIngredient;


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

// @todo: maybe have it in a hook and set to app?
$oDB = new PDO('sqlite:' . SQLITE_FILE);

//$app->setName('recipes');

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

//$app->get('/recipe/:id', function($id) use ($app) {
////    $app->flash('error', 'Login required');
//    $app->render('recipe_details.php', ['id' => $id, 'url' => $app->urlFor('recipe2', ['id' => $id])]);
//})->name('recipe2');

// ------- ROUTE SETTINGS -------

Route::setDefaultConditions(array(
    'id' => '\d+'
));

// ------- HOOKS -------
$app->hook('slim.before.dispatch', function() use ($app) {
    if (!$app->request->isAjax()) {
        $app->render('header.php');
    }
});

$app->hook('slim.after.dispatch', function() use ($app) {
    if (!$app->request->isAjax()) {
        $app->render('footer.php');
    }
});

// ------- RECIPES -------
$app->get('/', function() use ($app, $oDB) {
    $oRecipe = new Recipe($oDB);
    $recipes = $oRecipe->getAll();
//    $app->render('recipes.php', ['recipes' => $recipes]);
});

$app->get('/recipes', function() use ($app, $oDB) {
    $oRecipe = new Recipe($oDB);
    $recipes = $oRecipe->getAll();

    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', "application/json");
    $app->response->setBody(json_encode($recipes));
});

$app->get('/recipe', function() use ($app, $oDB) {
    $recipe = new stdClass();
    $recipeIngredients = [];
    $ingredients = [];

    $app->render('recipe.php', ['recipe' => $recipe, 'ingredients' => $ingredients, 'recipeIngredients' => $recipeIngredients]);
});

$app->post('/recipe', function() use ($app, $oDB) {
    $oRecipe = new Recipe($oDB);
    $id = $oRecipe->addFromRequest($app->request);
    $app->redirect('/recipe/' . $id);
});

$app->get('/recipe/:id', function($id) use ($app, $oDB) {
    $oRecipe = new Recipe($oDB);
    $recipe = $oRecipe->get($id);
    $oRecipeIngredient = new RecipeIngredient($oDB);
    $recipeIngredients = $oRecipeIngredient->getByRecipeId($recipe->id);
    $oIngredient = new Ingredient($oDB);
    $ingredients = $oIngredient->getAll();

    $app->render('recipe.php', ['recipe' => $recipe, 'ingredients' => $ingredients, 'recipeIngredients' => $recipeIngredients]);
});

$app->put('/recipe/:id', function($id) use ($app, $oDB) {
    $oRecipe = new Recipe($oDB);
    $oRecipe->updateFromRequest($app->request);
    $app->redirect('/recipe/' . $id);
});

// ------- RECIPE INGREDIENTS -------
$app->post('/recipeIngredients', function() use ($app, $oDB) {
    $oRecipeIngredient = new RecipeIngredient($oDB);
    $oRecipeIngredient->addFromRequest($app->request);

    $app->response->setStatus(201);
});

$app->put('/recipeIngredients/:id', function() use ($app, $oDB) {
    $oRecipeIngredient = new RecipeIngredient($oDB);
    $oRecipeIngredient->updateFromRequest($app->request);

    $app->response->setStatus(201);
});

$app->get('/recipeIngredients/:id', function($id) use ($app, $oDB) {
    $oRecipeIngredient = new RecipeIngredient($oDB);
    $row = $oRecipeIngredient->get($id);

    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', "application/json");
    $app->response->setBody(json_encode($row));
});

$app->delete('/recipeIngredients/:id', function($id) use ($app, $oDB) {
    $oRecipeIngredient = new RecipeIngredient($oDB);
    $oRecipeIngredient->delete($id);

    $app->response->setStatus(200);
});

// ------- INGREDIENTS -------
$app->get('/ingredients', function() use ($app, $oDB) {
    $oIngredient = new Ingredient($oDB);
    $ingredients = $oIngredient->getAll();
    $app->render('ingredients.php', ['ingredients' => $ingredients]);
});

$app->get('/ingredients/:id', function($id) use ($app, $oDB) {
    $oIngredient = new Ingredient($oDB);
    $row = $oIngredient->get($id);

    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', "application/json");
    $app->response->setBody(json_encode($row));
});

$app->post('/ingredients', function() use ($app, $oDB) {
    $oIngredient = new Ingredient($oDB);
    $oIngredient->addFromRequest($app->request);

    $app->response->setStatus(201);
});

$app->put('/ingredients/:id', function() use ($app, $oDB) {
    $oIngredient = new Ingredient($oDB);
    $oIngredient->updateFromRequest($app->request);

    $app->response->setStatus(201);
});

$app->delete('/ingredients/:id', function($id) use ($app, $oDB) {
    $oIngredient = new Ingredient($oDB);
    $oIngredient->delete($id);

    $app->response->setStatus(200);
});

$app->run();


function create_tables(PDO $oDB) {
    // creating recipe table
    $query[] = "
        CREATE TABLE IF NOT EXISTS recipe (
            id          INTEGER PRIMARY KEY,
            name        TEXT,
            description TEXT
        )
    ";

    // creating ingredient table
    $query[] = "
        CREATE TABLE IF NOT EXISTS ingredient (
            id      INTEGER PRIMARY KEY,
            name    TEXT,
            kcal    NUMERIC,
            protein NUMERIC,
            fat     NUMERIC,
            carb    NUMERIC
        )
    ";

    // creating recipe_ingredient table
    $query[] = "
        CREATE TABLE IF NOT EXISTS recipe_ingredient (
            id            INTEGER PRIMARY KEY,
            recipe_id     INTEGER,
            ingredient_id INTEGER,
            weight        INTEGER
        )
    ";

    $a = [];
    foreach ($query as $value) {
        $a[] = $oDB->query($value);
    }
}

function drop_tables(PDO $oDB) {
    $query[] = "DROP TABLE recipe";
    $query[] = "DROP TABLE ingredient";
    $query[] = "DROP TABLE recipe_ingredient";

    $a = [];
    foreach ($query as $value) {
        $a[] = $oDB->query($value);
    }
}

function recreate_tables(PDO $oDB) {
     drop_tables($oDB);
     create_tables($oDB);
}
