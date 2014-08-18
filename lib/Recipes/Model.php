<?php

namespace Recipes;

use Slim\Http\Request;
use Recipes\Exception\MissingTableNameException;

abstract class Model
{
    protected $oDB;
    protected $tableName;
    protected $rowClass = 'stdClass';

    final public function __construct(\PDO $oDB)
    {
        $this->oDB = $oDB;

        if (!is_string($this->tableName) || strlen($this->tableName) === 0) {
            throw new MissingTableNameException();
        }
    }

    public function get($id)
    {
        $stm = $this->oDB->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stm->execute([$id]);

        return $stm->fetch(\PDO::FETCH_CLASS, $this->rowClass);
    }

    public function getAll($orderBy = '')
    {
        $stm = $this->oDB->query("SELECT * FROM {$this->tableName}" . ($orderBy ? " ORDER BY {$orderBy}" : ""));

        return $stm->fetchall(\PDO::FETCH_OBJ);
    }

    public function delete($id)
    {
        $stm = $this->oDB->prepare("DELETE FROM {$this->tableName}  WHERE id = ?");
        $stm->execute([$id]);
    }

    abstract public function addFromRequest(Request $request);

    abstract public function updateFromRequest(Request $request);
}
