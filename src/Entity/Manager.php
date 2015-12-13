<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 01/12/15
 * Time: 19:18
 */

namespace ORM\Entity;


use ORM\Exception\InvalidArgument;
use ORM\Persistence\DeletePersist;
use ORM\Persistence\InsertPersist;
use ORM\Persistence\UpdatePersist;


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

       if(!empty($Entity->getId())) {
          $UpdatePersist = new UpdatePersist($Entity);
       } else {
           $InsertPersist = new InsertPersist($Entity);
       }
    }

    public function remove(Entity &$Entity)
    {
        $DeletePersist = new DeletePersist($Entity);
    }


}
