<?php
namespace core\database;
class Db
{
    private static $instance;
    private $connections;

    private function __construct()
    {
        $this->connections = [];
    }

    /**
     * @param string $driver
     * @return mixed
     */
    public static function getInstance($driver = 'mysql')
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance->getConnection($driver);
    }

    /**
     * @param string $driver
     * @return MysqlDbConnection
     */
    private function getConnection($driver)
    {
        if (!isset($this->connections[$driver]) || !is_object($this->connections[$driver])) {
            $this->addConnection($driver);
        }

        return $this->connections[$driver];
    }

    private function addConnection($driver)
    {
        $this->connections[$driver] = (new DbConnection($driver))->connect();
    }

    private function __clone()
    {
    }
}
