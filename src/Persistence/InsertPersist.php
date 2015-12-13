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
        $field = [];
        $value = [];
        $params = [];

        foreach($this->Entity->getFields() as $k => $v) {
            if(!empty($v)) {
                $value[] = '?';
                $field[] = $k;
                $params[] = $v;
            }
        };

        $Insert = new Insert();
        $sql = $Insert->into($this->Entity->getTable(), $field)->values($value)->toSql();
        try {
            $last_id = $this->persist([
                'sql' => $sql,
                'params' => $params
            ]);
        } catch (InvalidArgument $e) { die($e->cry()); }

        $this->Entity->setId($last_id);
    }
}