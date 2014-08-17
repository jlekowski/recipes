<?php
$recipe = $this->data['recipe'];
$recipeIngredients = $this->data['recipeIngredients'];
$ingredients = $this->data['ingredients'];
$total = ['weight' => 0, 'kcal' => 0, 'protein' => 0, 'fat' => 0, 'carb' => 0];
?>
<script src="/js/recipe.js"></script>
<div class="container">
    <h3><?=isset($recipe->name) ? $recipe->name : 'New Recipe'?></h3>
    <form class="form" method="POST">
        <?php if (isset($recipe->id)): ?>
        <input type="hidden" name="_METHOD" value="PUT"/>
        <?php endif; ?>
        <input type="hidden" id="recipe-id" name="id" value="<?=isset($recipe->id) ? $recipe->id : ''?>" />
        <fieldset>
            <div class="form-group row">
                <label for="recipe-name" class="col-lg-1 control-label">Name</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="recipe-name" name="name" value="<?=isset($recipe->name) ? $recipe->name : ''?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="recipe-description" class="col-lg-1 control-label">Description</label>
                <div class="col-lg-4">
                    <textarea class="form-control" id="recipe-description" name="description" rows="5"><?=isset($recipe->description) ? $recipe->description : ''?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-sm btn-primary recipe-edit">Save changes</button>
                </div>
            </div>
        </fieldset>
    </form>
    <?php if (isset($recipe->id)): ?>
    <h4>Ingredients <button type="button" class="btn btn-xs btn-success recipe-ingredient-add">+Add</button></h4>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Weight</th>
                <th>Calories (/100g)</th>
                <th>Protein (/100g)</th>
                <th>Fat (/100g)</th>
                <th>Carbohydrates (/100g)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipeIngredients as $recipeIngredient):
                    $total['weight'] += $recipeIngredient->weight;
                    $total['kcal'] += round($recipeIngredient->kcal / 100 * $recipeIngredient->weight, 2);
                    $total['protein'] += round($recipeIngredient->protein / 100 * $recipeIngredient->weight, 2);
                    $total['fat'] += round($recipeIngredient->fat / 100 * $recipeIngredient->weight, 2);
                    $total['carb'] += round($recipeIngredient->carb / 100 * $recipeIngredient->weight, 2);
            ?>
            <tr class="recipe-ingredient-edit" data-id="<?=$recipeIngredient->id?>">
                <td><a href="/ingredient/<?=$recipeIngredient->id?>"><?=$recipeIngredient->name?></a></td>
                <td><?=$recipeIngredient->weight?></td>
                <td><?=round($recipeIngredient->kcal / 100 * $recipeIngredient->weight, 2)?> (<?=$recipeIngredient->kcal?>)</td>
                <td><?=round($recipeIngredient->protein / 100 * $recipeIngredient->weight, 2)?> (<?=$recipeIngredient->protein?>)</td>
                <td><?=round($recipeIngredient->fat / 100 * $recipeIngredient->weight, 2)?> (<?=$recipeIngredient->fat?>)</td>
                <td><?=round($recipeIngredient->carb / 100 * $recipeIngredient->weight, 2)?> (<?=$recipeIngredient->carb?>)</td>
                <td><i class="glyphicon glyphicon-remove recipe-ingredient-delete"></i></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <?php if (!empty($recipeIngredients)): ?>
        <tfoot>
            <tr>
                <th>TOTAL:</th>
                <th class="col-lg-1"><input type="text" class="form-control input-sm" id="recipe-weight" value="<?=$total['weight']?>" /></th>
                <th>
                    <span class="total-weight"><?=$total['kcal']?></span>
                    (<span class="per100-weight"><?=round($total['kcal'] / $total['weight'] * 100, 2)?></span>)
                </th>
                <th>
                    <span class="total-weight"><?=$total['protein']?></span>
                    (<span class="per100-weight"><?=round($total['protein'] / $total['weight'] * 100, 2)?></span>)
                </th>
                <th>
                    <span class="total-weight"><?=$total['fat']?></span>
                    (<span class="per100-weight"><?=round($total['fat'] / $total['weight'] * 100, 2)?></span>)
                </th>
                <th>
                    <span class="total-weight"><?=$total['carb']?></span>
                    (<span class="per100-weight"><?=round($total['carb'] / $total['weight'] * 100, 2)?></span>)
                </th>
                <th></th>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
    <?php endif; ?>
</div>
<!-- Modal -->
<div class="modal fade" id="recipe-ingredient-add-modal" tabindex="-1" role="dialog" aria-labelledby="recipe-ingredient-add-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="recipe-ingredient-add-modal-label">Add recipe ingredient</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" id="recipe-ingredient-id" name="id" value="" />
                    <input type="hidden" name="recipe_id" value="<?=$recipe->id?>" />
                    <fieldset>
                        <div class="form-group form-group-sm">
                            <label for="recipe-ingredient-id" class="col-lg-2 control-label small">Ingredient</label>
                            <div class="col-lg-6">
                                <select class="form-control" id="recipe-ingredient-id" name="ingredient_id">
                                    <?php foreach ($ingredients as $ingredient): ?>
                                    <option value="<?=$ingredient->id?>"><?=$ingredient->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="recipe-ingredient-weight" class="col-lg-2 control-label small">Weight</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="recipe-ingredient-weight" name="weight" placeholder="weight">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="recipe-ingredient-add-submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="recipe-ingredient-delete-modal" tabindex="-1" role="dialog" aria-labelledby="recipe-ingredient-delete-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="recipe-ingredient-delete-modal-label">Delete recipe ingredient</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete ingredient <strong class="recipe-ingredient-delete-name"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-danger" id="recipe-ingredient-delete-submit">Delete</button>
            </div>
        </div>
    </div>
</div>
