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


$Category = new \Entity\Category();
$Category->setName('My Category');

$Article = new \Entity\Article();
$Article->setTitle('My first article');
$Article->setContent('My content of my first article with category My Category');
$Article->setCategory($Category);

$EntityManager->persist($Article);