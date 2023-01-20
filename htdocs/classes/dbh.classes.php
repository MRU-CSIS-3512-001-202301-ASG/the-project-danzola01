<?php

class Dbh
{

    protected function connect()
    {
        $servername = "34.68.130.132";
        $username = "root";
        $password = "comp3512";
        $dbname = "travel";

        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Connection failed: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}