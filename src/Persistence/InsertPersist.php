<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 11:53
 */

namespace ORM\Persistence;


use ORM\Exception\InvalidArgument;
use ORM\QueryBuilder\Insert;

class InsertPersist extends Persist
{
    protected function analyze()
    {
        $Insert = new Insert();
        $sql = $Insert->into($this->Entity->getTable(), $this->Entity->getFieldsName())->toSql();
        try {
            $last_id = $this->persist([
                'sql' => $sql,
                'params' => $this->Entity->getFieldsValue()
            ]);
        } catch (InvalidArgument $e) { die($e->cry()); }

        $this->Entity->setId($last_id);
    }
}