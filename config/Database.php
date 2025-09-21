<?php

namespace Config;

use PDO;

class Database
{

    private static PDO $instance;

    public function __construct() {}

    public static function getConnect(): PDO
    {
        if (!isset(self::$instance)) {
            self::$instance = new PDO("mysql:host=localhost;dbname=API", "root", "Root.123");
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}


/* 
    PARA criar DB
    
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    );

*/