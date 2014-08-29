<?php

namespace Recipes;

use Slim\Http\Request;

class RecipeIngredient
{
    protected $oDB;

    public function __construct(\PDO $oDB)
    {
        $this->oDB = $oDB;
    }

    public function addFromRequest(Request $request)
    {
        $body = json_decode($request->getBody());
        $stm = $this->oDB->prepare("INSERT INTO recipe_ingredient VALUES (NULL, ?, ?, ?)");
        $stm->execute([$body->recipe_id, $body->ingredient_id, $body->weight]);

        return $this->oDB->lastInsertId();
    }

    public function updateFromRequest(Request $request)
    {
        $body = json_decode($request->getBody());
        $stm = $this->oDB->prepare("UPDATE recipe_ingredient SET weight = ? WHERE id = ?");
        $stm->execute([$body->weight, $body->id]);
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
        $stm = $this->oDB->query("SELECT * FROM recipe_ingredient");

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }

    public function getByRecipeId($recipeId)
    {
        $stm = $this->oDB->query("SELECT i.*, ri.* FROM recipe_ingredient AS ri JOIN ingredient AS i ON ri.ingredient_id = i.id WHERE ri.recipe_id = ?");
        $stm->execute([$recipeId]);

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }
}
