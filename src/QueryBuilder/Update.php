<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 10:26
 */

namespace ORM\QueryBuilder;


use ORM\QueryBuilder\Clause\ClauseInterface;
use ORM\QueryBuilder\Clause\From as FromClause;
use ORM\QueryBuilder\Clause\Set as SetClause;
use ORM\QueryBuilder\Clause\Where as WhereClause;

class Update implements ClauseInterface
{

    use FromClause;
    use SetClause;
    use WhereClause;


    public function from($table)
    {
        $this->setFrom($table);
        return $this;
    }

    public function set($values)
    {
        $this->setSetValues($values);
        return $this;
    }

    public function toSql()
    {
        $query = 'UPDATE';
        $query .= str_replace('FROM ', '', $this->buildFrom());
        $query .= $this->buildSet();
        $query .= $this->buildWhere();
        return $query;
    }

}