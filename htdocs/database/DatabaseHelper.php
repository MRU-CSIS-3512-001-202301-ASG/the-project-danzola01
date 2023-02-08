<?php

// This project will only focus on posts made by the user with ID 23
define('TARGET_USER', 23);

class DatabaseHelper
{
    public $dbh;

    public function __construct($config)
    {
        $servername = $config['server_name'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['db_name'];

        $dsn = "mysql:host=$servername;dbname=$dbname";
        try {
            $this->dbh = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        } catch (PDOException $e) {
            die("The connection to the database failed");
        }
    }

    public function close_connection()
    {
        $this->dbh = null;
    }

    public function run($sql, $params = [])
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getDb()
    {
        if ($this->dbh instanceof PDO) {
            return $this->dbh;
        }
    }
}
