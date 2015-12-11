<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 09:55
 */

namespace ORM\QueryBuilder\Clause;


trait Values
{
    private $values;

    protected function setValues($values)
    {
        $this->values = $values;
    }

    protected function getValues()
    {
        return $this->values;
    }

    private function parseString($values)
    {
        $array = [];
        foreach($values as $v) {
            $array[] = (is_int($v) || empty($v)) ? $v : '\''.$v.'\'';
        }
        return $array;
    }

    protected  function buildValues()
    {
        $query = ' VALUES';
        $query .= '('.implode(', ', $this->parseString($this->getValues())).')';
        return $query;
    }
}