<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 03/12/15
 * Time: 21:54
 */

namespace ORM\Entity;


use ORM\Entity\Relationship\ManyToMany;
use ORM\Entity\Relationship\ManyToOne;
use ORM\Entity\Relationship\OneToMany;
use ORM\Entity\Relationship\OneToOne;

class Entity
{
    const EXPLODE_CHAR = '_';

    public function getTable()
    {
        $namespace = get_class($this);
        if(strpos($namespace, '\\')) {
            $namespace = explode('\\', $namespace);
            $namespace = array_reverse($namespace);
            $namespace = $namespace[0];
        }
        return strtolower($namespace);
    }

    public function getAlias()
    {
        $fields_name = $this->getFieldsName();
        $array = [];
        foreach($fields_name as $v) {
            $array[] = $v.' AS '.$this->getTable().self::EXPLODE_CHAR.$v;
        }
        return $array;
    }

    public function getFieldsName()
    {
        $array = array_keys(get_object_vars($this));
        array_shift($array);
        return $array;
    }

    public function getFieldsValue()
    {
        $array = array_values(get_object_vars($this));
        array_shift($array);
        return $array;
    }

}