<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 12:07
 */

namespace ORM\Persistence;


use ORM\Exception\InvalidArgument;
use ORM\QueryBuilder\Update;

class UpdatePersist extends Persist
{
    public function analyze()
    {
        $Update = new Update();
           $sql = $Update->from($this->Entity->getTable())->set($this->Entity->getFieldsName())->where('id', '=', $this->Entity->getId())->toSql();
           try {
              $this->persist([
                  'sql' => $sql,
                  'params' => $this->Entity->getFieldsValue()
              ]);
           } catch (InvalidArgument $e) { die($e->cry()); }
    }
}