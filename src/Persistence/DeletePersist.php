<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 12:15
 */

namespace ORM\Persistence;


use ORM\Exception\InvalidArgument;
use ORM\QueryBuilder\Delete;

class DeletePersist extends Persist
{
    protected function analyze()
    {
        $params = [];

        foreach($this->Entity->getFields() as $k => $v) {
            if(!empty($v)) {
                $params[] = $v;
            }
        };

        $Delete = new Delete();
        $sql = $Delete->from($this->Entity->getTable())->where('id', '=', $this->Entity->getId())->toSql();
        try {
            $this->persist([
                'sql' => $sql,
                'params' => []
            ]);
        } catch (InvalidArgument $e) { die($e->cry()); }
    }
}