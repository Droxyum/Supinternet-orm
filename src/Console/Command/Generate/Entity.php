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
        $code .= "class $this->_className extends Entity \n{ \n";

        foreach($this->fieldsList as $k => $v) {
            $code .= "    protected $$v; \n";
        }

        $code .= "\n \n";

        foreach($this->fieldsList as $k => $v) {
            $code .= "    public function set".ucfirst($v)."($$v) { \n";
            $code .= '        $this->'.$v.' = $'.$v.";\n";
            $code .= "    } \n \n";

            $code .= "    public function get".ucfirst($v)."() { \n";
            $code .= '         return $this->'.$v.";\n";
            $code .= "    } \n \n";
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