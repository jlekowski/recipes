<?php

namespace Recipes;

use Slim\Http\Request;

class RecipeTable extends Model
{
    protected $tableName = 'recipe';
    protected $rowClass = 'Recipe';

    public function addFromRequest(Request $request)
    {
        $stm = $this->oDB->prepare("INSERT INTO recipe VALUES (NULL, ?, ?)");
        $stm->execute([$request->post('name'), $request->post('description')]);

        return $this->oDB->lastInsertId();
    }

    public function updateFromRequest(Request $request)
    {
        $stm = $this->oDB->prepare("UPDATE recipe SET name = ?, description = ? WHERE id = ?");
        $stm->execute([$request->put('name'), $request->put('description'), $request->put('id')]);
    }
}
