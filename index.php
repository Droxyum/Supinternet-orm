<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 25/11/15
 * Time: 10:23
 */

require 'vendor/autoload.php';

$Connection = new \ORM\Connection('localhost', 'orm', 'root', 'abx24z4hb9zX');
$EntityManager = new \ORM\Entity\Manager();

/*$Article = new \Entity\Article();
$Article->setId(22);
$Article->setContent('sdf sdfq sdqsdq drticle');
$Article->setTitle('s d f');
$EntityManager->remove($Article);*/


$Articles = $EntityManager->getRepository('Entity:Article')->findAll();

var_dump($Articles);
