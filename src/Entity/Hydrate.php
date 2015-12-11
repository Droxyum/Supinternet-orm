<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 06/12/15
 * Time: 16:49
 */

namespace ORM\Entity;


class Hydrate
{
    private $explode_char = '_';

    private $sqlResult;

    public function setSqlResult($sql_result)
    {
        $this->sqlResult = $sql_result;
    }

    public function getSqlResult()
    {
        return $this->sqlResult;
    }

    public function hydrate()
    {
        $arrayToReturn = [];
        foreach($this->sqlResult as $row) {
            $row = $this->removeNumericIndex($row);
            $arrayToReturn[] = $this->hydrateRow($row);
        }
        return $arrayToReturn;
    }

    private function hydrateRow($row)
    {
        $Entities = [];
        foreach($row as $index => $value) {
            $table = $this->getTableFromIndex($index);
            $field = $this->getFieldNameFromIndex($index);
            $setter = 'set'.ucfirst($field);
            if(empty($Entities)) {
                $namespace = 'Entity\\'.ucfirst($table);
                $Entities = new $namespace();
            }
            $Entities->$setter($value);
            unset($row[$index]);
        }
        return $Entities;
    }


    private function getTableFromIndex($index)
    {
        return explode($this->explode_char, $index)[0];
    }

    private function getFieldNameFromIndex($index)
    {
        return explode($this->explode_char, $index)[1];
    }


    private function removeNumericIndex(array $array)
    {
        foreach($array as $k => $v) {
            if(is_array($v)) {
                $this->removeNumericIndex($array);
            } else {
                if(is_numeric($k)) {
                    unset($array[$k]);
                }
            }
        }
        return $array;
    }

}