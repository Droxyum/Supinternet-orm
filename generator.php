<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 10:58
 */

require 'vendor/autoload.php';

$Connection = new \ORM\Connection('localhost', 'orm', 'root', 'abx24z4hb9zX');
$Console = new \ORM\Console\Console('\\Entity', $argv);