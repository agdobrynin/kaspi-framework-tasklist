<?php

namespace Core\Orm;

use Core\Orm\Query\EntityBuilder;
use Core\Orm\Query\Filter;
use Core\Orm\Query\Limit;
use Core\Orm\Query\Order;
use ReflectionClass;
use ReflectionProperty;

abstract class Entity
{
    /** @var ReflectionClass */
    private $entityClass;
    /** @var array */
    private $fields = [];
    /** @var EntityBuilder */
    private $entityBuilder;
    /** @var string */
    protected $table;
    /** @var string первичный ключ таблицы */
    protected $primaryKey = 'id';
    /** @var mixed свойство первичного ключа */
    public $id;

    protected function getEntityClass(): ReflectionClass
    {
        if (null === $this->entityClass) {
            try {
                $this->entityClass = new ReflectionClass($this);
            } catch (\ReflectionException $exception) {
                throw new OrmException($exception->getMessage());
            }
        }

        return $this->entityClass;
    }

    private function getProperties(): array
    {
        if (empty($this->fields)) {
            foreach ($this->getEntityClass()->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
                $this->fields[] = $property->getName();
            }
        }

        return $this->fields;
    }

    /**
     * @param mixed $id Entity's primary key
     *
     * @throws OrmException
     */
    public static function find($id): Entity
    {
        $class = static::class;
        /** @var Entity $entity */
        $entity = new $class();
        $collection = (new Collection($entity))
            ->addFilter((new Filter())->add($entity->getPrimaryKey(), $id))
            ->addOrder((new Order())->add($entity->getPrimaryKey(), 'ASC'))
            ->addLimit(new Limit(1, 1));

        return $collection->getCollection()[0] ?? $entity;
    }

    public static function first(): Entity
    {
        $class = static::class;
        /** @var Entity $entity */
        $entity = new $class();
        $collection = (new Collection($entity))
            ->addOrder((new Order())->add($entity->getPrimaryKey(), 'ASC'))
            ->addLimit(new Limit(1, 1));

        return $collection->getCollection()[0] ?? $entity;
    }

    public static function last(): Entity
    {
        $class = static::class;
        /** @var Entity $entity */
        $entity = new $class();
        $collection = (new Collection($entity))
            ->addOrder((new Order())->add($entity->getPrimaryKey(), 'DESC'))
            ->addLimit(new Limit(1, 1));

        return $collection->getCollection()[0] ?? $entity;
    }

    /**
     * Удяляет всю таблицу Entity.
     */
    public static function truncate(): int
    {
        $class = static::class;
        /** @var Entity $entity */
        $entity = new $class();

        return $entity->getEntityBuilder()->truncate();
    }

    public function getEntityBuilder(): EntityBuilder
    {
        if (null === $this->entityBuilder) {
            $this->entityBuilder = new EntityBuilder($this);
        }

        return $this->entityBuilder;
    }

    public function getTable(): string
    {
        // имя таблицы во множественном числе + s если не опеделено в классе
        if (empty($this->table)) {
            $this->table = strtolower($this->getEntityClass()->getShortName()).'s';
        }

        return $this->table;
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function getEntityDataParams(): ?array
    {
        $paramsEntity = [];
        foreach ($this->getProperties() as $property) {
            if ('id' === $property) {
                continue;
            }
            $paramsEntity[$property] = $this->{$property};
        }

        return $paramsEntity;
    }

    public function save(): ?int
    {
        if ($this->id) {
            $this->getEntityBuilder()->update();
        } else {
            $this->getEntityBuilder()->insert();
        }

        return $this->id;
    }

    public function delete(): bool
    {
        if ($res = $this->getEntityBuilder()->delete()) {
            $this->empty();

            return $res;
        }

        return false;
    }

    protected function empty(): void
    {
        foreach ($this->getProperties() as $property) {
            $this->{$property} = null;
        }
    }
}
