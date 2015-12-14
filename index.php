<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 25/11/15
 * Time: 10:23
 */

require 'vendor/autoload.php';

$Connection = new \ORM\Connection('', '', '', '');
$EntityManager = new \ORM\Entity\Manager();

$Articles = $EntityManager->getRepository('Entity:Article')->findAll(['doRelations' => ['Category']]);

var_dump($Articles);