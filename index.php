<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 25/11/15
 * Time: 10:23
 */

require_once './vendor/autoload.php';

$Connection = new \ORM\Connection('localhost', 'suporm', 'suporm', 'suporm');
$EntityManager = new \ORM\Entity\Manager();

/*$Category = new \Entity\Category();
$Category->setName('My category');
$EntityManager->persist($Category);*/

/*$Article = new \Entity\Article();
$Article->setId(40);
$Article->setTitle('sdfsdfst');
$Article->setContent('Msdfsdtent');
$EntityManager->remove($Article);*/


$Article = $EntityManager->getRepository('Entity:Article')->findAll(['doRelations' => ['Category']]);
var_dump($Article);
