<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 01/12/15
 * Time: 17:53
 */

namespace ORM\Exception;


class Exception extends \Exception
{
    protected $className;

    public function setClassName($className)
    {
        $this->className = $className;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function cry()
    {
        return 'Error in: '.$this->getClassName().': '.$this->getMessage().' -  line '.$this->getLine()."\n";
    }
}