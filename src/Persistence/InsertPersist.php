<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 11:53
 */

namespace ORM\Persistence;


use ORM\Entity\Mapping\ManyToOne;
use ORM\Exception\InvalidArgument;
use ORM\QueryBuilder\Insert;

class InsertPersist extends Persist
{
    protected function analyze()
    {
        $Relations = [];

        if($this->Entity->hasRelationship() && !$this->Entity->isRelationshipEmpty()) {
            foreach($this->Entity->getRelationFields() as $relation) {
                $getter = 'get'.ucfirst($relation);
                $relation = $this->Entity->$getter();
                switch($relation::RELATION_TYPE) {
                    case ManyToOne::RELATION_TYPE:
                        $r = $relation->get();
                        $Relations[] = ['field' => $r::TABLE.'_id', 'value' => $relation->get()->getId()];
                }
            }
        }

        $fieldsName = $this->Entity->getFieldsName();
        $fieldsParams = $this->Entity->getFieldsValue();

        if (!empty($Relations)) {
            foreach($Relations as $relation) {
                $fieldsName[] = $relation['field'];
                $fieldsParams[] = $relation['value'];
            }
        }

        $Insert = new Insert();
        $entity = $this->Entity;
        $sql = $Insert->into($entity::TABLE, $fieldsName)->toSql();
        try {
            $last_id = $this->persist([
                'sql' => $sql,
                'params' => $fieldsParams
            ]);
        } catch (InvalidArgument $e) { die($e->cry()); }

        $this->Entity->setId($last_id);
    }
}