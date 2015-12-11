<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 18:01
 */

namespace ORM\QueryBuilder\Helper;


class Exist implements HelperInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getReturn()
    {
        return !empty($this->data);
    }

}