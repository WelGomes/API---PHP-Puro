<?php

namespace Config;

use PDO;

class Database
{
    private static PDO $instance;

    public function __construct() {}

    public static function connect(): PDO
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_PREFETCH           => 100,
        ];

        if (!isset(self::$instance)) {
            self::$instance = new PDO("mysql:host=localhost;dbname=API", "root", "Root.123", $options);
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