<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 10:33
 */

namespace ORM\QueryBuilder\Clause;


trait Set
{
    private $set = [];


    protected function setSetValues($values)
    {
        $this->set = $values;
    }

    protected function getSetValues()
    {
        return $this->set;
    }

    protected function buildSet()
    {
        $array = [];

        foreach ($this->getSetValues() as $v) { $array[] = $v.' = ?'; }
        $query = ' SET ';
        $query .= implode(', ', $array);
        return $query;
    }
}