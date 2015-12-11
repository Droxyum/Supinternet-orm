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

    private function parseString($values)
    {
        return (is_int($values) || empty($values)) ? $values : '\''.$values.'\'';
    }

    protected function buildSet()
    {
        $array = [];

        foreach ($this->getSetValues() as $k => $v) { $array[] = $k.' = '.$this->parseString($v); }
        $query = ' SET ';
        $query .= implode(', ', $array);
        return $query;
    }
}