<?php
namespace core\database;

use core\Config as Config;

/**
 * Iskus Anton. Email: iskus1981@yandex.ru
 * IDE PhpStorm. 12.04.2015
 */
class DbConnection
{//extends PDO {
    public function __construct($driver)
    {
        $this->config = Config::getDbConfig($driver);
        $this->driver = $driver;

    }

    /**
     * Run this private methods (mysql|mongo|others...)Connect()
     * @return object DbConnection
     */
    public function connect()
    {
        return $this->{"{$this->driver}Connect"}();
    }

    /**
     * @return MysqlDbConnection
     */
    private function mysqlConnect()
    {
        $mysql = new MysqlDbConnection(
            $this->config->host,
            $this->config->user,
            $this->config->pass,
            $this->config->db
        );

        $mysql->set_charset('utf8');
        //$this->character_set_name();

        return $mysql;
    }

    private function mongoConnect()
    {

    }
}