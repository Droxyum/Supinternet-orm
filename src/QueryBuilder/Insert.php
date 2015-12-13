<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 09:45
 */

namespace ORM\QueryBuilder;


use ORM\QueryBuilder\Clause\ClauseInterface;
use ORM\QueryBuilder\Clause\Into as IntoClause;
use ORM\QueryBuilder\Clause\Values as ValuesClause;

class Insert implements ClauseInterface
{
    use IntoClause;
    use ValuesClause;

    public function into($table, $values = false)
    {
        $this->setInto($table);
        if($values) {
            $this->setIntoValues($values);
            $array = [];
            foreach($values as $v) {
                $array[] = '?';
            }
            $this->values($array);
        }
        return $this;
    }

    public function values($values)
    {
        $this->setValues($values);
        return $this;
    }

    public function toSql()
    {
        $query = 'INSERT';
        $query .= $this->buildInto();
        $query .= $this->buildValues();
        return $query;
    }


}