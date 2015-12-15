<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 09/12/15
 * Time: 11:47
 */

namespace ORM\Console\Command\Generate;


use ORM\Connection;

class Entity
{
    private $_tableName;
    private $_className;
    private $_entityNamespace;
    private $fieldsList = [];

    public function __construct($EntityNamespace, $arg)
    {
        array_shift($arg);
        $this->_entityNamespace = $EntityNamespace;
        $this->_tableName = $arg[0];
        $this->_className = ucfirst($arg[1]);
        if (!empty($arg[2]) && !empty($arg[3]) && !empty($arg[4]) && !empty($arg[5])) {
            Connection::resetConnection($arg[2], $arg[3], $arg[4], $arg[5]);
        }
        $this->fieldsList = $this->getFieldsListFromDatabase();
        $this->generate();
    }

    private function getFieldsListFromDatabase()
    {
        $Connection = Connection::getConnection();
        $request = $Connection->prepare("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM `information_schema`.`COLUMNS` WHERE TABLE_SCHEMA LIKE ? AND TABLE_NAME LIKE ?");
        $request->execute([Connection::getDatabaseName(), $this->_tableName]);
        $array = [];
        foreach($request->fetchAll() as $k => $v) {
            $array[] = $v['COLUMN_NAME'];
        }
        return $array;
    }

    private function generate()
    {
        $code = "<?php \n \n";
        $code .= "namespace Entity; \n \n";
        $code .= "use ORM\\Entity\\Entity; \n \n";

        foreach($this->fieldsList as $k => $v) {
            if(strstr($v, '_id')) {
                $code .= "use ORM\\Entity\\Mapping\\ManyToOne; \n \n";
            }
        }

        $code .= "class $this->_className extends Entity \n{ \n";

        $code .= "\tconst TABLE = '$this->_tableName'; \n";

        foreach($this->fieldsList as $k => $v) {
            if(!strstr($v, '_id')) {
                $code .= "\tprotected $$v; \n";
            } else {
                $v = explode('_', $v);
                $code .= "\tprotected $".ucfirst($v[0])."; \t // Join field on \\Entity\\Category \n";
            }
        }



        $code .= "\n \n";

        $code .= "\tpublic function __construct() { \n";
        foreach($this->fieldsList as $k => $v) {
            if(strstr($v, '_id')) {
                $v = explode('_', $v);
                $v = ucfirst($v[0]);
                $code .= "\t\t".'$this->'.$v." = new ManyToOne(".'$this, \'\\Entity\\'.$v.'\''."); \n";
            }
        }
        $code .= "\t} \n \n";



        $code .= "\n \n";

        foreach($this->fieldsList as $k => $v) {
            if(!strstr($v, '_id')) {
                $code .= "\tpublic function set".ucfirst($v)."($$v) { \n";
                $code .= "\t\t".'$this->'.$v.' = $'.$v.";\n";
                $code .= "\t} \n \n";

                $code .= "\tpublic function get".ucfirst($v)."() { \n";
                $code .= "\t\t".'return $this->'.$v.";\n";
                $code .= "\t} \n \n";
            } else {
                $v = explode('_', $v);
                $v = $v[0];

                $code .= "\tpublic function set".ucfirst($v)."($$v) { \n";
                $code .= "\t\t".'$this->'.ucfirst($v)."->set($".$v."); \n";
                $code .= "\t} \n \n";

                $code .= "\tpublic function get".ucfirst($v)."() { \n";
                $code .= "\t\t".'return $this->'.ucfirst($v).";\n";
                $code .= "\t} \n \n";
            }
        }

        $code .= "}";
        file_put_contents('Entity/'.$this->_className.'.php', $code);

        $code = "<?php \n \n";
        $code .= "namespace Entity; \n \n";
        $code .= "use ORM\\Entity\\Repository; \n \n";
        $code .= "class ".$this->_className."Repository extends Repository \n{ \n";
        $code .= "} \n \n";

        file_put_contents('Entity/'.$this->_className.'Repository.php', $code);

    }

}