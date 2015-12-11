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

    const MAPPED = 'mapped';
    const INVERSED = 'inversed';

    protected function oneToMany($type, $foreign_key = null) {
        return new OneToMany($type, $foreign_key);
    }

    protected function manyToOne($type, $foreign_key = null) {
        return new ManyToOne($type, $foreign_key);
    }

    protected function oneToOne($type, $foreign_key = null) {
        return new OneToOne($type, $foreign_key);
    }

    protected function manyToMany($type, $join_table = null) {
        return new ManyToMany($type, $join_table);
    }

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

    public function getFieldsAlias($vars = false, $table = false)
    {
        if(!$vars) {
            $fields = get_object_vars($this);
        } else {
            $fields = $vars;
        }
        $fieldsToReturn = [];
        foreach($fields as $k => $v) {
            if (!is_object($fields[$k])) {
                if(!$table) {
                    $fieldsToReturn[] = $this->getTable().'.'.$k.' AS '.$this->getTable().'_'.$k;
                } else {
                    $fieldsToReturn[] = $table.'.'.$k.' AS '.$table.'_'.$k;
                }
            } else {
                $e = $v->getNewEntity();
                $fieldsToReturn = array_merge($fieldsToReturn, $this->getFields(get_object_vars($e), $e->getTable()));
            }
        }
        return $fieldsToReturn;
    }

    public function getFields()
    {
        return get_object_vars($this);
    }

}