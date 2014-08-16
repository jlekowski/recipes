<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recipes</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">-->
<!--    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>body {font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 14px;}</style>-->
    <!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">-->
<!--    @import url("//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css")-->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="/js/ingredients.js"></script>
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
                <li><a href="/">Recipes</a></li>
                <li class="active"><a href="/ingredients">Ingredients</a></li>
<!--                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>-->
            </ul>
<!--            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li-cs
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>-->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    <button type="button" class="btn btn-sm btn-success ingredient-add">Add Ingredient</button>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Calories/100g</th>
                <th>Proteins/100g</th>
                <th>Fat/100g</th>
                <th>Carbohydrates/100g</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->data['ingredients'] as $ingredient): ?>
            <tr class="ingredient-edit" data-id="<?=$ingredient->id?>">
                <td><?=$ingredient->name?></td>
                <td><?=$ingredient->kcal?></td>
                <td><?=$ingredient->protein?></td>
                <td><?=$ingredient->fat?></td>
                <td><?=$ingredient->carb?></td>
                <td><i class="glyphicon glyphicon-remove ingredient-delete"></i><td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="ingredient-add-modal" tabindex="-1" role="dialog" aria-labelledby="ingredient-add-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="ingredient-add-modal-label">Add ingredient</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" id="ingredient-id" name="id" value="" />
                    <fieldset>
                        <div class="form-group form-group-sm">
                            <label for="ingredient-name" class="col-lg-3 control-label small">Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-name" name="name" placeholder="egg, flour">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="ingredient-kcal" class="col-lg-3 control-label small">Calories</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-kcal" name="kcal" placeholder="calories">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="ingredient-calories-standard" class="col-lg-3 control-label small">Proteins</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-protein" name="protein" placeholder="proteins in 100g">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="ingredient-calories-standard" class="col-lg-3 control-label small">Fat</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-fat" name="fat" placeholder="fat in 100g">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="ingredient-calories-standard" class="col-lg-3 control-label small">Carbohydrates</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-carb" name="carb" placeholder="carbs in 100g">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="ingredient-add-submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ingredient-delete-modal" tabindex="-1" role="dialog" aria-labelledby="ingredient-delete-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="ingredient-delete-modal-label">Delete ingredient</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete ingredient <strong class="ingredient-delete-name"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-danger" id="ingredient-delete-submit">Delete</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
