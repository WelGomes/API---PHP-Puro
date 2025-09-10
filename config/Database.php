<?php

namespace Config;

use Exception;
use PDO;

class Database
{

    public static function getConnect(): PDO
    {
        try {

            $pdo = new PDO("mysql:host=localhost;dbname=API", "root", "Root.123");
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }

        return $pdo;
    }
}
