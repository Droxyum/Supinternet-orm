<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 07:38
 */

namespace ORM\QueryBuilder\Clause;


trait Select
{
    private $fields = '*';


    protected function getFields()
    {
        return $this->fields;
    }

    protected function setFields($fields)
    {
        $this->fields = $fields;
    }

    protected function buildFields()
    {
        $query = 'SELECT ';
        (is_array($this->getFields())) ? $query .= implode(', ', $this->getFields()) : $query .= $this->getFields();
        return $query;
    }
}