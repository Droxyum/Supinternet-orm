<?php

namespace ORM\QueryBuilder;

use ORM\Connection;
use ORM\Entity\Hydrate;
use ORM\Entity\Manager;
use ORM\Entity\Mapping\ManyToOne;
use ORM\Exception\InvalidArgument;
use ORM\Tools\Logger;

class QueryBuilder
{
    public static function execute(array $array = [])
    {

        $array['type'] = explode(' ', $array['sql'])[0];
        $array['fn'] = (!empty($array['fn'])) ? $array['fn'] : false;
        $array['params'] = (!empty($array['params'])) ? $array['params'] : [];


        if(empty($array['sql'])) {
            $e = new InvalidArgument('sql params not set in QueryBuilder::execute()');
            $e->setClassName(get_class());
        }

        $Connection = Connection::getConnection();
        $request = $Connection->prepare($array['sql']);

        if($request->execute($array['params'])) {
            $Logger = new Logger(dirname(dirname(__DIR__)).'/access.log');
            $Logger->add($array['sql']);
        } else {
            $errorInfo = $request->errorInfo();
            $Logger = new Logger(dirname(dirname(__DIR__)).'/error.log');
            $Logger->add($array['sql'].' | '.$errorInfo[2]);
        }



        if($array['type'] == 'SELECT' || $array['fn']) {

            if($array['fn']) {
                $namespace = 'ORM\\QueryBuilder\\Helper\\'.ucfirst(strtolower($array['fn']));
                $Object = new $namespace($request->fetchAll());
                return $Object->getReturn();
            } else {

                $Hydrate = new Hydrate();
                $Hydrate->setSqlResult($request->fetchAll());
                $Entities = $Hydrate->hydrate();

                if(!empty($array['doRelations']) && is_array($array['doRelations'])) {
                    foreach($Entities as $k => $Entity) {
                        foreach($array['doRelations'] as $relation) {
                            $relation = ucfirst(strtolower($relation));
                            $setter = 'set'.$relation;
                            $getter = 'get'.$relation;
                            $Relation = $Entity->$getter();
                            switch($Relation::RELATION_TYPE){
                                case ManyToOne::RELATION_TYPE:
                                    $EntityManager = new Manager();
                                    $$relation = $EntityManager->getRepository('Entity:'.$relation)->findAll();
                                    $join_id = self::query('SELECT '.strtolower($relation).'_id as join_id FROM '.$Entity->getTable().' WHERE id = ?', [$Entity->getId()])[0]['join_id'];
                                    foreach($$relation as $relationFetch) {
                                        if($relationFetch->getId() == $join_id) {
                                            $Entities[$k]->$setter($relationFetch);
                                        }
                                    }
                            }
                        }
                    }
                }

                return $Entities;
            }

        }

        if($array['type'] == 'INSERT') {
            return $Connection->lastInsertId();
        }

        if($array['type'] == 'UPDATE') {
            return true;
        }

    }

    public static function query($sql, $params = [])
    {
        $Connection = Connection::getConnection();
        $request = $Connection->prepare($sql);
        if($request->execute($params)) {
            $Logger = new Logger(dirname(dirname(__DIR__)).'/access.log');
            $Logger->add($sql);
        } else {
            $errorInfo = $request->errorInfo();
            $Logger = new Logger(dirname(dirname(__DIR__)).'/error.log');
            $Logger->add($sql.' | '.$errorInfo[2]);
        }
        return $request->fetchAll();
    }
}
