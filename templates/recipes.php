<?php
$recipes = $this->data['recipes'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recipes</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="/js/recipes.js"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="glyphiconicon-bar"></span>
                <span class="glyphiconicon-bar"></span>
                <span class="glyphiconicon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Recipes</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Recipes</a></li>
                <li><a href="/ingredients">Ingredients</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h3>Recipes <a href="/recipe" class="btn btn-xs btn-success recipe-add">+Add</a></h3>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
            <tr class="recipe-row" data-id="<?=$recipe->id?>">
                <td><?=$recipe->id?></td>
                <td><a href="/recipe/<?=$recipe->id?>"><?=$recipe->name?></a></td>
                <td><i class="glyphicon glyphicon-remove recipe-ingredient-delete"></i></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
