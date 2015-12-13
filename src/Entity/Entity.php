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
        $array = get_object_vars($this);
        array_shift($array);
        $toReturn = [];
        foreach($array as $k => $v) {
            if(!$this->isRelationship($k)) {
                $toReturn[] = $k;
            }
        }
        return $toReturn;
    }

    public function getFieldsValue()
    {
        $array = get_object_vars($this);
        array_shift($array);
        $toReturn = [];
        foreach($array as $k => $v) {
            if(!$this->isRelationship($k)) {
                $toReturn[] = $v;
            }
        }
        return $toReturn;
    }

    public function getRelationFields()
    {
        $array = get_object_vars($this);
        array_shift($array);
        $toReturn = [];
        foreach($array as $k => $v) {
            if($this->isRelationship($k)) {
                $toReturn[] = $k;
            }
        }
        return $toReturn;
    }

    public function hasRelationship()
    {
        $array = get_object_vars($this);
        array_shift($array);
        $hasRelationship = false;
        foreach($array as $k => $v) {
            if($this->isRelationship($k)) {
                $hasRelationship = true;
                break;
            }
        }
        return $hasRelationship;
    }

    public function isRelationship($field)
    {
        $getter = 'get'.ucfirst($field);
        return is_object($this->$getter());
    }

    public function isRelationshipEmpty()
    {
        $empty = false;
        foreach($this->getRelationFields() as $field) {
            $getter = 'get'.ucfirst($field);
            if($this->$getter()->isEmpty()) {
                $empty = true;
                break;
            }
        }
        return $empty;
    }

}