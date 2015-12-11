<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 27/11/15
 * Time: 15:17
 */

namespace ORM;


class Connection
{
    private static $conn = false;
    private static $_database;

    public function __construct($host, $database, $username, $password)
    {
        if(!self::$conn) {
            self::$_database = $database;
            try {
                self::$conn = new \PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
            } catch(\PDOException $e) {
                die($e->getMessage());
            }
            self::$conn->query("SET NAMES utf8;");
        }
    }

    static function getConnection()
    {
        return self::$conn;
    }

    static function getDatabaseName()
    {
        return self::$_database;
    }

    public static function resetConnection($host, $database, $username, $password)
    {
        self::$_database = $database;
        self::$conn = new \PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
        self::$conn->query("SET NAMES utf8;");
    }

}