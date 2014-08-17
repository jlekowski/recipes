<?php

namespace Recipes;

class RecipeIngredient
{
    protected $oDB;

    public function __construct(\PDO $oDB)
    {
        $this->oDB = $oDB;
    }

    public function addFromRequest(\Slim\Http\Request $request)
    {
        $stm = $this->oDB->prepare("INSERT INTO recipe_ingredient VALUES (NULL, ?, ?, ?)");
        $stm->execute([$request->post('recipe_id'), $request->post('ingredient_id'), $request->post('weight')]);
    }

    public function updateFromRequest(\Slim\Http\Request $request)
    {
        $stm = $this->oDB->prepare("UPDATE recipe_ingredient SET weight = ? WHERE id = ?");
        $stm->execute([$request->put('weight'), $request->put('id')]);
    }

    public function delete($id)
    {
        $stm = $this->oDB->prepare("DELETE FROM recipe_ingredient WHERE id = ?");
        $stm->execute([$id]);
    }

    public function get($id)
    {
        $stm = $this->oDB->prepare("SELECT * FROM recipe_ingredient WHERE id = ?");
        $stm->execute([$id]);

        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        $stm = $this->oDB->query("SELECT * FROM recipe_ingredient ORDER BY name");

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }

    public function getByRecipeId($recipeId)
    {
        $stm = $this->oDB->query("SELECT i.*, ri.* FROM recipe_ingredient AS ri JOIN ingredient AS i ON ri.ingredient_id = i.id WHERE ri.recipe_id = ? ORDER BY name");
        $stm->execute([$recipeId]);

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }
}