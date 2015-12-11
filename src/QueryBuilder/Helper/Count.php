<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 17:47
 */

namespace ORM\QueryBuilder\Helper;


class Count implements HelperInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getReturn()
    {
        return count($this->data);
    }


}