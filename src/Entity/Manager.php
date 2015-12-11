<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 01/12/15
 * Time: 19:18
 */

namespace ORM\Entity;


use ORM\Exception\InvalidArgument;
use ORM\QueryBuilder\QueryBuilder;
use ORM\QueryBuilder\Update;
use ORM\QueryBuilder\Insert;
use ORM\QueryBuilder\Delete;


class Manager
{

    public function getRepository($Entity)
    {
        $Entity = str_replace(':', '\\', $Entity);
        $Repository = $Entity.'Repository';
        return new $Repository(new $Entity());
    }

    public function persist(Entity &$Entity) {

        if (!is_object($Entity)) {
            $e = new InvalidArgument('$Entity must an Entity class');
            $e->setClassName(get_class());
        }

       if(!empty($Entity->getId())) {
           $Update = new Update();
           $sql = $Update->from($Entity->getTable())->set($Entity->getFields())->where('id', '=', $Entity->getId())->toSql();
           QueryBuilder::execute([
               'type' => 'UPDATE',
               'sql' => $sql
           ]);
       } else {
           $field = [];
           $value = [];

           foreach($Entity->getFields() as $k => $v) {
               if(!empty($v)) {
                   $value[] = '?';
                   $field[] = $k;
               }
           };

           $Insert = new Insert();
           $sql = $Insert->into($Entity->getTable(), $field)->values($value)->toSql();
           $Entity->setId(QueryBuilder::execute([
               'type' => 'INSERT',
               'sql' => $sql,
               'params' => array_values($Entity->getFields())
           ]));
       }
    }

    public function remove(Entity &$Entity) {

        if (!is_object($Entity)) {
            $e = new InvalidArgument('$Entity must an Entity class');
            $e->setClassName(get_class());
        }

        $Delete = new Delete();
        $sql = $Delete->from($Entity->getTable())->where('id', '=', $Entity->getId())->toSql();
        QueryBuilder::execute([
            'type' => 'DELETE',
            'sql' => $sql
        ]);
    }


}
