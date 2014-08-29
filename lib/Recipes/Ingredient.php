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
        $body = json_decode($request->getBody());
        $stm = $this->oDB->prepare("INSERT INTO ingredient VALUES (NULL, ?, ?, ?, ?, ?)");
        $stm->execute([$body->name, $body->kcal, $body->protein, $body->fat, $body->carb]);

        return $this->oDB->lastInsertId();
    }

    public function updateFromRequest(Request $request)
    {
        $body = json_decode($request->getBody());
        $stm = $this->oDB->prepare("UPDATE ingredient SET name = ?, kcal = ?, protein = ?, fat = ?, carb = ? WHERE id = ?");
        $stm->execute([$body->name, $body->kcal, $body->protein, $body->fat, $body->carb, $body->id]);
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
        $stm = $this->oDB->query("SELECT * FROM ingredient");

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }
}
