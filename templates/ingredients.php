<?php
$recipe = $this->data['recipe'];
$recipeIngredients = $this->data['recipeIngredients'];
$ingredients = $this->data['ingredients'];
$total = ['weight' => 0, 'kcal' => 0, 'protein' => 0, 'fat' => 0, 'carb' => 0];
?>
<script src="/js/ingredients.js"></script>
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
