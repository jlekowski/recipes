<?php

namespace Recipes;

use Slim\Http\Request;

class Ingredient
{
    protected $oDB;

    public function __construct(\PDO $oDB)
    {
        $this->oDB = $oDB;
    }

    public function addFromRequest(Request $request)
    {
        $stm = $this->oDB->prepare("INSERT INTO ingredient VALUES (NULL, ?, ?, ?, ?, ?)");
        $stm->execute([$request->post('name'), $request->post('kcal'), $request->post('protein'), $request->post('fat'), $request->post('carb')]);
    }

    public function updateFromRequest(Request $request)
    {
        $stm = $this->oDB->prepare("UPDATE ingredient SET name = ?, kcal = ?, protein = ?, fat = ?, carb = ? WHERE id = ?");
        $stm->execute([$request->put('name'), $request->put('kcal'), $request->put('protein'), $request->put('fat'), $request->put('carb'), $request->put('id')]);
    }

    public function delete($id)
    {
        $stm = $this->oDB->prepare("DELETE FROM ingredient WHERE id = ?");
        $stm->execute([$id]);
    }

    public function get($id)
    {
        $stm = $this->oDB->prepare("SELECT * FROM ingredient WHERE id = ?");
        $stm->execute([$id]);

        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        $stm = $this->oDB->query("SELECT * FROM ingredient ORDER BY name");

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }
}
