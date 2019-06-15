<?php

class CSV extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = $this->getConnection();
    }

    public function insert($table, $fields)
    {

        $keys = "" . implode(',', array_keys($fields)) . "";
        $values = "'" . implode("','", array_values($fields)) . "'";
        $sql = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $values . ")";
        $res = $this->db->query($sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
