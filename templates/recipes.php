<?php
$recipes = $this->data['recipes'];
?>
<script src="/js/recipes.js"></script>
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
