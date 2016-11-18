<?php
namespace core;

use core\database\Db as Db;

/**
 * Iskus Anton. Email: iskus1981@yandex.ru
 * IDE PhpStorm. 12.04.2015
 */
class Model
{
    /**
     * @var \core\database\MysqlDbConnection
     */
    public $Db;

    public function __construct()
    {
        $this->Db = Db::getInstance('mysql');
        $this->setDbTable();
    }

    public function setDbTable($table = FALSE)
    {
        if ($table) {
            $this->Db->table = $table;
        } else {
            $fullClassName = explode('\\', strtolower(get_class($this)));
            $this->Db->table = $fullClassName[count($fullClassName) - 1];
        }
    }

    public function addEntity($obj)
    {
        return $this->Db->insert($obj);
    }

    public function addEntitys(array $objects)
    {
        return $this->Db->multiInsert($objects);
    }

    public function getEntity($id)
    {
        return $this->Db->getRow((int)$id);
    }

    public function setEntity($id, $params)
    {
        return $this->Db->update((int)$id, $params);
    }

    public function getEntitys($params = [], $start = 0, $count = 0)
    {
        return $this->Db->getRows($params, $start, $count);
    }

}