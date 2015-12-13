<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 16:57
 */

namespace ORM\Entity\Mapping;


class ManyToOne
{
    private $Entity;
    private $relationEntity;

    private $relationData;

    public function __construct(&$Entity, $relationEntity)
    {
        $this->Entity;
        $this->relationEntity = $relationEntity;
    }

    public function getEntity()
    {
        return $this->Entity;
    }

    public function getNewRelationEntity()
    {
        return new $this->relationEntity();
    }

    public function set($Entity)
    {
        $this->relationData = $Entity;
    }

    public function get()
    {
        return $this->relationData;
    }

    public function isEmpty()
    {
        return empty($this->relationData);
    }
}