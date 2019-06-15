<?php

include_once 'conn.php';

class Table extends Database
{
    private $table;
    private $db;

    public function __construct($t)
    {
        $this->table = $t;
        $this->db = $this->getConnection();
    }

    public function create_table($headers)
    {
        $table_columns = array();

        foreach ($headers as $header) {
            $table_columns[] = $header . ' VARCHAR(255)';
        }

        $sql = 'CREATE TABLE ' . $this->table .  '(' . implode(',', $table_columns) . ')';

        $result = $this->db->query($sql);

        return $result;
    }

    public function is_table_exist()
    {
        $sql = "SELECT 1 FROM $this->table LIMIT 1";

        $result = $this->db->query($sql);

        return $result;
    }
}
