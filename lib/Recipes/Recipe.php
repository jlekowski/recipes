<?php

namespace Recipes;

class Recipe
{
    protected $oDB;

    public function __construct(\PDO $oDB)
    {
        $this->oDB = $oDB;
    }

    public function addFromRequest(\Slim\Http\Request $request)
    {
        $stm = $this->oDB->prepare("INSERT INTO recipe VALUES (NULL, ?, ?)");
        $stm->execute([$request->post('name'), $request->post('description')]);

        return $this->oDB->lastInsertId();
    }

    public function updateFromRequest(\Slim\Http\Request $request)
    {
        $stm = $this->oDB->prepare("UPDATE recipe SET name = ?, description = ? WHERE id = ?");
        $stm->execute([$request->put('name'), $request->put('description'), $request->put('id')]);
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
        $stm = $this->oDB->query("SELECT * FROM recipe ORDER BY name");

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }
}