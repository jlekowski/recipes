<?php

$oDB = new PDO("sqlite:../db/recipes.sqlite");

//$oDB->query("INSERT INTO ingredient VALUES(1, 'jaja', 'szt', 100, " . time() . ")");
//echo "<pre>" . print_r($oDB->errorInfo(), 1);
//exit;

$stm = $oDB->query("SELECT * FROM ingredient");
$ingredients = $stm->fetchall(\PDO::FETCH_OBJ);
//var_dump($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Recipes</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="http://bootswatch.com/yeti/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script>
    $().ready(function() {
        $('#ingredient-add-modal').modal('show');

        $('#ingredient-portion-calories, #ingredient-calories-standard').on('change', function() {
            var portionWeight = $('#ingredient-portion-weight').val(),
                $this = $(this);
            if (portionWeight == 0) {
                return;
            }

            if ($this.attr('id') === 'ingredient-portion-calories') {
                $('#ingredient-calories-standard').val(Math.round(portionWeight / $this.val() * 100, 2));
            } else {
                $('#ingredient-portion-calories').val(Math.round(portionWeight / 100 * $this.val(), 2));
            }
        });

        $('#ingredient-portion-weight').on('change', function() {
            var standardCalories = $('#ingredient-calories-standard').val();
            if (standardCalories == 0) {
                return;
            }

            $('#ingredient-portion-calories').val(Math.round($(this).val() / 100 * standardCalories, 2));
        });

        $('#ingredient-add-submit').on('click', function() {
            $.ajax({
                url: '/ingredients',
                type: 'POST',
                data: $('#ingredient-add-modal form').serialize()
            });
        });
    });
    </script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
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
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
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
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    <button type="button" class="btn btn-xs btn-success ingredient-add" data-toggle="modal" data-target="#ingredient-add-modal">Add Ingredient</button>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Portion weight</th>
                <th>Portion calories</th>
                <th>Calories/100g</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ingredients as $ingredient): ?>
            <tr>
                <td><?=$ingredient->name ?></td>
                <td><?=$ingredient->unit ?></td>
                <td><?=$ingredient->calories ?></td>
                <td><?=$ingredient->calories ?></td>
                <td><i class="glyphicon glyphicon-remove ingredient-delete"></i><td>
                <!--<td><?=date('Y-m-d H:i:s', $ingredient->timestamp) ?></td>-->
            </tr>
            <?php endforeach; ?>
            <tr>
                <td><input type="text" placeholder="name" /></td>
                <td><input type="text" placeholder="unit" /></td>
                <td><input type="text" placeholder="calories" /></td>
                <td><input type="text" placeholder="calories" /></td>
                <td><button type="button" class="btn btn-xs btn-success ingredient-add">Add</button></td>
                <!--<td><?=date('Y-m-d H:i:s', $ingredient->timestamp) ?></td>-->
            </tr>
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="ingredient-add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add ingredient</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="ingredient-name" class="col-lg-3 control-label">Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-name" name="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ingredient-portion-weight" class="col-lg-3 control-label">Portion weight</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-portion-weight" name="portion-weight" placeholder="Portion weight">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ingredient-portion-calories" class="col-lg-3 control-label">Portion calories</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-portion-calories" name="portion-calories" placeholder="Portion calories">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ingredient-calories-standard" class="col-lg-3 control-label">Calories in 100g</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="ingredient-calories-standard" name="standard-calories" placeholder="Calories in 100g">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-xs" id="ingredient-add-submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
