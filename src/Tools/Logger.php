<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 11/12/15
 * Time: 13:24
 */

namespace ORM\Tools;


class Logger
{
    private $file;


    public function __construct($file)
    {
        $this->file = $file;
    }

    public function add($string)
    {
        $content = '';
        if(file_exists($this->file)) {
            $content = file_get_contents($this->file);
        }
        $content .= '['.\date('m/d/Y h:i:s a', time()).'] '.$string."\n";
        file_put_contents($this->file, $content);
    }
}