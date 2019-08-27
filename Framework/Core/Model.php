<?php

namespace Core;

use Core\Exception\ModelException;

class Model
{
    private $dbInstance;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct(\PDO $instance)
    {
        $this->dbInstance = $instance;
        // Таблицы во множественном числе называть object + s
        $this->table = (new \ReflectionClass($this))->getShortName().'s';
    }

    public function getInstance(): \PDO
    {
        return $this->dbInstance;
    }

    public function prepare($sql): \PDOStatement
    {
        if (!$sth = $this->dbInstance->prepare($sql)) {
            throw new ModelException($this->dbInstance->errorInfo());
        }

        return $sth;
    }
}
