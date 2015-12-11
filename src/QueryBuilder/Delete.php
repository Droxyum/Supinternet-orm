<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 10:19
 */

namespace ORM\QueryBuilder;


use ORM\QueryBuilder\Clause\ClauseInterface;
use ORM\QueryBuilder\Clause\From as FromClause;
use ORM\QueryBuilder\Clause\Where as WhereClause;

class Delete implements ClauseInterface
{
    use FromClause;
    use WhereClause;

    public function from($table)
    {
        $this->setFrom($table);
        return $this;
    }

    public function toSql()
    {
        $query = 'DELETE';
        $query .= $this->buildFrom();
        $query .= $this->buildWhere();
        return $query;
    }


}