<?php

namespace ORM\QueryBuilder;

use ORM\Connection;
use ORM\Entity\Hydrate;
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
                return $Hydrate->hydrate();
            }

        }

        if($array['type'] == 'INSERT') {
            return $Connection->lastInsertId();
        }

        if($array['type'] == 'UPDATE') {
            return true;
        }

    }
}
