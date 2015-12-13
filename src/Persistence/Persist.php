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

    protected $lasId;

    public function __construct(&$Entity)
    {
        $this->Entity = $Entity;
        $this->analyze();
    }

    public static function checkPersistenceType(&$Entity, $delete = false)
    {
        if(!$delete) {
            if(!empty($Entity->getId())) {
                return new UpdatePersist($Entity);
            } else {
                return new InsertPersist($Entity);
            }
        } else {
            return new DeletePersist($Entity);
        }
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