<?php

namespace Config;

use Wallet\controller\UserController;
use Wallet\repository\UserRepository;
use Wallet\service\UserService;

abstract class Container
{

    public static function getUserController(): UserController 
    {
        $json = json_decode(file_get_contents("php://input"), true);
        $database = Database::getConnect();
        $userRepository = new UserRepository($database);
        $userService = new UserService($userRepository);
        return new UserController($userService, $json);
    }

}