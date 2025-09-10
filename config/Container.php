<?php

namespace Config;

use Wallet\controller\UserController;
use Wallet\repository\UserRepository;
use Wallet\service\UserService;

abstract class Container
{

    public static function getUserController(): UserController 
    {
        $database = Database::getConnect();
        $userRepository = new UserRepository($database);
        $userService = new UserService($userRepository);
        return $userController = new UserController($userService);
    }

}