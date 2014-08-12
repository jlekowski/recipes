<?php

//echo $this->data['url'];

$oDB = new PDO("sqlite:../db/recipes.sqlite");

$stm = $oDB->query("SELECT * FROM recipe WHERE id = " . (int)$this->data['id']);
$recipe = $stm->fetch(\PDO::FETCH_OBJ);

//$oDB->query("INSERT INTO ingredient VALUES(1, 'szt', 100, " . time() . ")");
//$oDB->query("INSERT INTO recipe_ingredient VALUES(1, 1, 1, 2, " . time() . ")");

$stm = $oDB->query("SELECT * FROM ingredient AS i JOIN recipe_ingredient AS ri ON i.id = ri.ingredient_id"
    . " WHERE ri.recipe_id = " . $recipe->id);
$recipeDetails = $stm->fetchAll(\PDO::FETCH_OBJ);

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Recipes</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td>Name:</td>
                <td><input type="text" value="<?=$recipe->name ?>" /></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea><?=$recipe->description ?></textarea></td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Calories</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipeDetails as $recipeDetail): ?>
            <?php $total += $recipeDetail->quantity * $recipeDetail->calories ?>
            <tr>
                <td><input type="text" value="<?=$recipeDetail->id ?>" /></td>
                <td><input type="text" value="<?=$recipeDetail->unit ?>" /></td>
                <td><input type="text" value="<?=$recipeDetail->quantity ?>" /></td>
                <td><input type="text" value="<?=$recipeDetail->calories ?>" /></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Total: <?=$total?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
