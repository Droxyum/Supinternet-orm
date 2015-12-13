<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 11:54
 */

namespace ORM\Persistence;


use ORM\QueryBuilder\QueryBuilder;

class Persist
{
    protected $Entity;

    public function __construct(&$Entity)
    {
        $this->Entity = $Entity;
        $this->analyze();
    }

    protected function persist($array = [])
    {
        return QueryBuilder::execute($array);
    }

    protected function analyze() {}

    protected function getEntity()
    {
        return $this->Entity;
    }

}