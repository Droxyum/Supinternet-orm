<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 17:57
 */

namespace ORM\QueryBuilder\Helper;


interface HelperInterface
{
    public function __construct($data);
    public function getReturn();
}