<?php

namespace Core\Orm;

use Core\Orm\Query\Filter;
use Core\Orm\Query\Group;
use Core\Orm\Query\Having;
use Core\Orm\Query\Limit;
use Core\Orm\Query\Order;

class Collection
{
    protected $collection = [];
    /** @var Entity */
    protected $entity;
    /** @var Filter */
    protected $filter;
    /** @var Order */
    protected $order;
    /** @var Group */
    protected $group;
    /** @var Having */
    protected $having;
    /** @var Limit */
    protected $limit;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    public function addFilter(Filter $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function addLimit(Limit $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function addOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function addGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function addHaving(Having $having): self
    {
        $this->having = $having;

        return $this;
    }

    /**
     * @throws OrmException
     */
    public function getCollection(): array
    {
        return $this->entity->getEntityBuilder()->select(
            $this->filter,
            $this->order,
            $this->group,
            $this->having,
            $this->limit
        );
    }

    /**
     * @throws OrmException
     */
    public function count(): int
    {
        return $this->entity->getEntityBuilder()->count(
            $this->filter,
            $this->group
        );
    }
}
