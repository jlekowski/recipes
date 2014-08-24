<?php

namespace Recipes;

use Slim\Http\Request;

class Recipe
{
    protected $oDB;

    public function __construct(\PDO $oDB)
    {
        $this->oDB = $oDB;
    }

    public function addFromRequest(Request $request)
    {
        $body = json_decode($request->getBody());
        $stm = $this->oDB->prepare("INSERT INTO recipe VALUES (NULL, ?, ?)");
        $stm->execute([$body->name, $body->description]);

        return $this->oDB->lastInsertId();
    }

    public function updateFromRequest(Request $request)
    {
        $body = json_decode($request->getBody());
        $stm = $this->oDB->prepare("UPDATE recipe SET name = ?, description = ? WHERE id = ?");
        $stm->execute([$body->name, $body->description, $body->id]);
    }

    public function delete($id)
    {
        $stm = $this->oDB->prepare("DELETE FROM recipe WHERE id = ?");
        $stm->execute([$id]);
    }

    public function get($id)
    {
        $stm = $this->oDB->prepare("SELECT * FROM recipe WHERE id = ?");
        $stm->execute([$id]);

        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        $stm = $this->oDB->query("SELECT * FROM recipe");

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }
}
