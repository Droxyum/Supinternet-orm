<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 07:54
 */

namespace ORM\QueryBuilder\Clause;


trait Where
{
    private $where = [];

    protected function getWhere()
    {
        return $this->where;
    }

    public function where($field, $operator, $value)
    {
        $stm = $field.' '.$operator.' ';
        if (is_int($value)) { $stm .= $value; } else { $stm .= '\''.$value.'\''; }
        $this->where[] = $stm;
        return $this;
    }

    public function addWhere($field, $operator, $value)
    {
        $this->where[] = ' AND '.$field.' '.$operator.' '.$value;
        return $this;
    }

    public function orWhere($field, $operator, $value)
    {
        $this->where[] = ' OR '.$field.' '.$operator.' '.$value;
        return $this;
    }

    protected function buildWhere()
    {
        $query = '';
        if(!empty($this->getWhere())) {
            $query = ' WHERE ';
            $query .= implode(', ', $this->where);
        }
        return $query;
    }
}