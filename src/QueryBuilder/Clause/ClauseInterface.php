<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 08:36
 */

namespace ORM\QueryBuilder\Clause;


interface ClauseInterface
{
    public function toSql();
}