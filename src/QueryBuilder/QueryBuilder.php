<?php

namespace ORM\QueryBuilder;

use ORM\Connection;
use ORM\Entity\Hydrate;
use ORM\Tools\Logger;

class QueryBuilder
{
    public static function execute($type, $sql, $fn = false)
    {
        $Connection = Connection::getConnection();
        $request = $Connection->prepare($sql);
        $request->execute();

        $errorInfo = $Connection->errorInfo();
        if($errorInfo[0] == '00000') {
            $Logger = new Logger(dirname(dirname(__DIR__)).'/access.log');
            $Logger->add($sql);
        } else {
            $Logger = new Logger(dirname(dirname(__DIR__)).'/error.log');
            $Logger->add($sql.' | '.$errorInfo[2]);
        }



        if($type == 'SELECT' || $fn) {

            if($fn) {
                $namespace = 'ORM\\QueryBuilder\\Helper\\'.ucfirst(strtolower($fn));
                $Object = new $namespace($request->fetchAll());
                return $Object->getReturn();
            } else {
                $Hydrate = new Hydrate();
                $Hydrate->setSqlResult($request->fetchAll());
                return $Hydrate->hydrate();
            }

        }

        if($type == 'INSERT') {
            return $Connection->lastInsertId();
        }

        if($type == 'UPDATE') {
            return true;
        }

    }
}
