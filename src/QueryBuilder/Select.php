<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 07:38
 */

namespace ORM\QueryBuilder;


use ORM\QueryBuilder\Clause\ClauseInterface;
use ORM\QueryBuilder\Clause\From as FromClause;
use ORM\QueryBuilder\Clause\OrderBy as OrderByClause;
use \ORM\QueryBuilder\Clause\Select as SelectClause;
use ORM\QueryBuilder\Clause\Where as WhereClause;

class Select implements ClauseInterface
{
    use SelectClause;
    use FromClause;
    use WhereClause;
    use OrderByClause;


    public function select($fields)
    {
        $this->setFields($fields);
        return $this;
    }

    public function from($table)
    {
        $this->setFrom($table);
        return $this;
    }

    public function toSql()
    {
        $query = $this->buildFields();
        $query .= $this->buildFrom();
        $query .= $this->buildWhere();
        $query .= $this->buildOrderBy();

        return $query;
    }
}
