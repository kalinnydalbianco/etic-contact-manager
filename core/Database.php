<?php

class Database {

    private $connection;

    public function connect($configFile = '../configs/database.config.php') {        
        extract($this->ingestConfigFile($configFile));
        $dsn = sprintf("mysql:host=%s;dbname=%s;port=%d", $host, $name, $port);

        try {
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die('Error connecting to database. ' . $e->getMessage());
        }
    }

    private function ingestConfigFile($configFile) {
        if (!file_exists($configFile)) {
            throw new Exception('Database config not found');
        }

        $config = require $configFile;
        return $config;
    }

    public function query($sql) {
        try {
            $this->connection = $this->connect();
            return $this->connection->query($sql);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function select($table) {
        $stmt = $this->query("SELECT * FROM $table");
        return $stmt->fetchAll();
    }

    public function where($table, $where) {
        $where = $this->getWhere($where);
        $stmt = $this->query("SELECT * FROM $table WHERE $where");
        return $stmt->fetchAll();
    }

    public function byId($table, $id, $idField = 'id') {
        $rs = $this->where($table, "$idField = $id");
        return isset($rs[0]) ? $rs[0] : null;
    }

    public function insert($table, $data) {
        $fields = array_keys($data);
        $values = array_values($data);

        $fieldsAsString = implode(', ', $fields);
        $valuesAsString = implode("', '", $values);

        $sql = "INSERT INTO $table ($fieldsAsString) VALUES ('$valuesAsString')";
        $stmt = $this->query($sql);

        return [
            'stmt' => $stmt,
            'insertedId' => $this->connection->lastInsertId()
        ];
    }

    public function update($table, $data, $where) {
        $pairs = $this->pairs($data);
        $pairsAsString = implode(', ', $pairs);
        
        $where = $this->getWhere($where);
        $sql = "UPDATE $table SET $pairsAsString WHERE $where";
        
        return $this->query($sql);
    }

    public function delete($table, $where) {
        $where = $this->getWhere($where);
        $sql = "DELETE FROM $table WHERE $where";

        return $this->query($sql);
    }

    public function exists($table, $field, $value) {
        $sql = "SELECT COUNT(*) AS counter FROM $table WHERE $field = '$value' LIMIT 1";
        $stmt = $this->query($sql);
        $row = $stmt->fetch();

        return $row && $row->counter > 0;
    }

    private function pairs($data) {
        $pairs = [];
        foreach ($data as $key => $value) {
            $pairs[] = "$key = '$value'";
        }
        return $pairs;
    }

    private function getWhere($where) {
        if (is_array($where)) {
            $pairs = $this->pairs($where);
            return implode(' AND ', $pairs);
        }

        return $where;
    }
}