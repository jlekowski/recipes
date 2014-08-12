<?php

$oDB = new PDO("sqlite:../db/recipes.sqlite");

// creating recipe table
$query[] = "
    CREATE TABLE IF NOT EXISTS recipe (
        id          INTEGER PRIMARY KEY,
        name        TEXT,
        description TEXT,
        timestamp   NUMERIC
    )
";

// creating ingredient table
$query[] = "
    CREATE TABLE IF NOT EXISTS ingredient (
        id        INTEGER PRIMARY KEY,
        name      TEXT,
        unit      TEXT,
        calories  NUMERIC,
        timestamp NUMERIC
    )
";

// creating recipe_ingredient table
$query[] = "
    CREATE TABLE IF NOT EXISTS recipe_ingredient (
        id            INTEGER PRIMARY KEY,
        recipe_id     INTEGER,
        ingredient_id INTEGER,
        quantity      INTEGER,
        timestamp     NUMERIC
    )
";

$a = [];
foreach ($query as $value) {
    $a[] = $oDB->query($value);
}


//$oDB->query("INSERT INTO recipe VALUES(1,'test', 'test recipe', " . time() . ")");
//echo "<pre>" . print_r($oDB->errorInfo(), 1);
//exit;

$stm = $oDB->query("SELECT * FROM recipe");
$recipes = $stm->fetchall(\PDO::FETCH_OBJ);
//var_dump($result);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Recipes</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<body>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recipes as $recipe): ?>
            <tr>
                <td><a href="/recipe/<?= $recipe->id ?>"><?= $recipe->name ?></a></td>
                <td><?= date('Y-m-d H:i:s', $recipe->timestamp) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
