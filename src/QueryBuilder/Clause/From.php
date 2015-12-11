<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 07:47
 */

namespace ORM\QueryBuilder\Clause;


trait From
{
    private $from = [];


    protected function getFrom()
    {
        return $this->from;
    }

    protected function setFrom($from)
    {
        $this->from[] = $from;
    }

    protected function buildFrom()
    {
        $query = '';
        if(!empty($this->getFrom())) {
            $query .= ' FROM '.implode(', ', $this->getFrom());
        }
        return $query;
    }
}