<?php

class Database
{
    private $connection;

    public function __construct()
    {
        $this->connect('localhost', 'iti', 'root', '');
    }

    private function connect($host, $database, $username, $password)
    {
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
        try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print_r($e->getMessage());
        }
    }

    public function insert($table, $columns)
    {
        $columnNames = implode(',', array_keys($columns));
        $placeholders = implode(',', array_fill(0, count($columns), '?'));

        $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);

        try {
            $stmt->execute(array_values($columns));
            echo "Record inserted successfully.";
        } catch (PDOException $e) {
            echo "Insertion failed: " . $e->getMessage();
        }
    }

    public function select($table)
    {
        $query = "SELECT * FROM $table";
        $stmt = $this->connection->query($query);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function selectById($table, $id)
    {
        $query = "SELECT * FROM $table WHERE id = ?";
        $stmt = $this->connection->prepare($query);

        try {
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Deletion failed: " . $e->getMessage();
        }
    }

    public function selectByCondition($table, $condition)
    {
        $query = "SELECT * FROM $table WHERE $condition";
        $stmt = $this->connection->query($query);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function update($table, $id, $fields)
    {
        $setFields = array();
        foreach ($fields as $column => $value) {
            $setFields[] = "$column = ?";
        }
        $setFields = implode(', ', $setFields);

        $query = "UPDATE $table SET $setFields WHERE id = ?";
        $stmt = $this->connection->prepare($query);

        try {
            $stmt->execute(array_merge(array_values($fields), [$id]));
            echo "Record updated successfully.";
        } catch (PDOException $e) {
            echo "Update failed: " . $e->getMessage();
        }
    }

    public function delete($table, $id)
    {
        $query = "DELETE FROM $table WHERE id = ?";
        $stmt = $this->connection->prepare($query);

        try {
            $stmt->execute([$id]);
            echo "Record deleted successfully.";
        } catch (PDOException $e) {
            echo "Deletion failed: " . $e->getMessage();
        }
    }
}
