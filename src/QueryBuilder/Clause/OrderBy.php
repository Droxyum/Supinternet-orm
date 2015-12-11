<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 17:35
 */

namespace ORM\QueryBuilder\Clause;


trait OrderBy
{
    protected $order = [];

    protected function getOrderBy()
    {
        return $this->order;
    }

    public function orderBy($field, $order)
    {
        $this->order[] = $field.' '.$order;
        return $this;
    }

    public function addOrderBy($field, $order)
    {
        $this->order[] = ' AND '.$field.' '.$order;
        return $this;
    }


    protected function buildOrderBy()
    {
        $query = '';
        if(!empty($this->getOrderBy())) {
            $query = ' ORDER BY ';
            $query .= implode(', ', $this->order);
        }
        return $query;
    }
}