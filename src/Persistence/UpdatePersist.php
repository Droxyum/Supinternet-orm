<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 13/12/15
 * Time: 12:07
 */

namespace ORM\Persistence;


use ORM\Entity\Mapping\ManyToOne;
use ORM\Exception\InvalidArgument;
use ORM\QueryBuilder\Update;

class UpdatePersist extends Persist
{
    public function analyze()
    {
        $Relations = [];

        if($this->Entity->hasRelationship() && !$this->Entity->isRelationshipEmpty()) {
            foreach($this->Entity->getRelationFields() as $relation) {
                $getter = 'get'.ucfirst($relation);
                $relation = $this->Entity->$getter();
                switch($relation::RELATION_TYPE) {
                    case ManyToOne::RELATION_TYPE:
                        $Relations[] = ['field' => $relation->get()->getTable().'_id', 'value' => $relation->get()->getId()];
                }
            }
        }

        $fieldsName = $this->Entity->getFieldsName(); array_shift($fieldsName);
        $fieldsParams = $this->Entity->getFieldsValue(); array_shift($fieldsParams);

        if (!empty($Relations)) {
            foreach($Relations as $relation) {
                $fieldsName[] = $relation['field'];
                $fieldsParams[] = $relation['value'];
            }
        }

        $Update = new Update();
           $sql = $Update->from($this->Entity->getTable())->set($fieldsName)->where('id', '=', $this->Entity->getId())->toSql();
           try {
              $this->persist([
                  'sql' => $sql,
                  'params' => $fieldsParams
              ]);
           } catch (InvalidArgument $e) { die($e->cry()); }
    }
}