<?php
namespace core\database;

/**
 * Iskus Anton. Email: iskus1981@yandex.ru
 * IDE PhpStorm. 15.04.2015
 */

class MysqlDbConnection extends \mysqli
{
    public $table;


    public function insert(\stdClass $obj)
    {
        $values = [];
        foreach ($obj as $field => $value) {
            $values[$field] = $value;
        }
        $inc = "INSERT";
        if (isset($values['replace']) && $values['replace'] === TRUE) {
            unset($values['replace']);
            $inc = "REPLACE";
        }
        $query = "{$inc} INTO {$this->table} (" . implode(',', array_keys($values))
            . ") VALUES ('" . implode("','", $values) . "')";
        echo $query;
        return $this->query($query);

    }

    public function multiInsert(array $objects)
    {
        $inc = "INSERT";
        if (isset($objects['replace']) && $objects['replace'] === TRUE) {
            unset($objects['replace']);
            $inc = "REPLACE";
        }
        $query = "{$inc} INTO {$this->table} (" . implode(',', array_keys(get_object_vars($objects[0])))
            . ") VALUES ";
        $values = [];
        foreach ($objects as $obj) {
            $vars = [];
            foreach ($obj as $field => $var) {
                $vars[$field] = $var;
            }
            $values[] = "('" . implode("','", $vars) . "')";
        }
        //var_dump($values);

        $query .= implode(",", $values);
        echo $query;
        try {
            $this->query($query);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
//        var_dump($this->query($query));die;
//        return $this->query($query);

    }

    public function getRow($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = " . (int)$id;
        echo $query;
        $result = $this->query($query);
        return $result->fetch_object();
    }

    public function update($id, $params)
    {
        $set = [];
        foreach ($params as $key => $val) {
            $set[] = "$key = '{$val}'";
        }
        $query = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id = " . (int)$id;
        return $this->query($query);

    }

    public function getRows($params = [], $start = 0, $count = 0)
    {
        $where = '';
        $limit = '';
        if ($count) $limit .= 'LIMIT ' . $start . ', ' . $count;
        if (is_array($params) && !empty($params)) {
            $where = [];
            foreach ($params as $key => $val) {
                if (is_array($val)) {
                    $where[] = "$key IN ('" . implode("', '", $val) . "')";
                } else {
                    $where[] = "$key = '{$val}'";
                }
            }
            $where = "WHERE " . implode(' AND ', $where);
        }
        $query = "SELECT * FROM {$this->table} {$where} {$limit}";
//var_dump($query);
//        $result = $this->query($query)->fetch_all();
//        var_dump($result);
        if (!$result = $this->query($query)) return FALSE;

        $out = [];
        while ($row = $result->fetch_object()) {
            $out[$row->id] = $row;
        }
//        var_dump($out); die;
        return $out;
    }

}