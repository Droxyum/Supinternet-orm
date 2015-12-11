<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 04/12/15
 * Time: 08:08
 */

namespace ORM\Entity;



use ORM\QueryBuilder\QueryBuilder;
use ORM\QueryBuilder\Select;

abstract class Repository
{
    protected $Entity;

    public function __construct(Entity $Entity)
    {
        $this->Entity = $Entity;
    }

    public function findAll()
    {
        $Select = new Select();
        $sql = $Select->select($this->Entity->getFieldsAlias())->from($this->Entity->getTable())->toSql();
        return QueryBuilder::execute('SELECT', $sql, 'Count');
    }
}