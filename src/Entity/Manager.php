<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 01/12/15
 * Time: 19:18
 */

namespace ORM\Entity;


use ORM\Exception\InvalidArgument;
use ORM\Persistence\Persist;


class Manager
{

    public function getRepository($Entity)
    {
        $Entity = str_replace(':', '\\', $Entity);
        $Repository = $Entity.'Repository';
        return new $Repository(new $Entity());
    }

    public function persist(Entity &$Entity)
    {

        if (!is_object($Entity)) {
            $e = new InvalidArgument('$Entity must an Entity class');
            $e->setClassName(get_class());
        }

        $Persistence = Persist::checkPersistenceType($Entity);
    }

    public function remove(Entity &$Entity)
    {
        if (!is_object($Entity)) {
            $e = new InvalidArgument('$Entity must an Entity class');
            $e->setClassName(get_class());
        }

        $Persistence = Persist::checkPersistenceType($Entity, true);
    }


}
