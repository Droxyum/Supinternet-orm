<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 04/12/15
 * Time: 08:08
 */

namespace ORM\Entity;



use ORM\QueryBuilder\Join;
use ORM\QueryBuilder\QueryBuilder;
use ORM\QueryBuilder\Select;

abstract class Repository
{
    protected $Entity;

    public function __construct(Entity $Entity)
    {
        $this->Entity = $Entity;
    }

    public function findAll($params = [])
    {
        $Select = new Select();
        $entity = $this->Entity;
        $sql = $Select->select($this->Entity->getAlias())->from($entity::TABLE)->toSql();

        $executeParams = [
            'type' => 'SELECT',
            'sql' => $sql
        ];

        if(!empty($params['doRelations']) && is_array($params['doRelations'])) {
            $executeParams['doRelations'] = $params['doRelations'];
        }

        return QueryBuilder::execute($executeParams);
    }
}