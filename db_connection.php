<?php

class DbConnection
{
    private $conn;

    // this constructor function returns the connection to the mysql database
    function __construct() {
        $this->conn = mysqli_connect('localhost', 'root', 'Root8848', 'web_shop_php') or die('database connection failed');

        return $this->conn;
    }

// database connection string
   public function getDbConnection()
    {
        return $this->conn;
    }
}

