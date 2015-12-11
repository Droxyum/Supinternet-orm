<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 09:46
 */

namespace ORM\QueryBuilder\Clause;


trait Into
{
    private $into;
    private $intoValues;


    protected function getInto()
    {
        return $this->into;
    }

    protected function setInto($into)
    {
        $this->into = $into;
    }

    protected function setIntoValues($values)
    {
        $this->intoValues = $values;
    }

    protected function getIntoValues()
    {
        return $this->intoValues;
    }

    protected function buildInto()
    {
        $query = ' INTO ';
        $query .= $this->getInto();
        $query .= '('.implode(', ', $this->getIntoValues()).')';
        return $query;
    }
}