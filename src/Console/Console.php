<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 10:57
 */

namespace ORM\Console;

        //0 command
        //1 tablename
        //2 classname
        //3 host OPTIONAL
        //4 user OPTIONAL
        //5 pass OPTIONAL
        //6 db OPTIONAL

class Console
{
    private $_entityNamespace;

    public function __construct($EntityNamespace, array &$arg)
    {
        $this->_entityNamespace = $EntityNamespace.'\\';
        array_shift($arg);
        $this->parser($arg);
    }

    private function parser($arg)
    {
        $command = $arg[0];
        $command = explode(':', $command);
        foreach($command as $k => $v) { $command[$k] = ucfirst($v); }
        $namespace = '\\ORM\\Console\\Command\\'.implode('\\', $command);
        $Command = new $namespace($this->_entityNamespace, $arg);
    }
}