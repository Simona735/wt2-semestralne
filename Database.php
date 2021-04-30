<?php

require_once "config.php";

class Database
{
    private $connection;

    public function getConnection(){
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=". DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->connection->exec("set names utf8");

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->connection;
    }
}
