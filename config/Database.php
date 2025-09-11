<?php

namespace Config;

use Exception;
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
