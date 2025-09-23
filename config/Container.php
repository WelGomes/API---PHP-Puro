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
        $authentication = new Authentication('Chave_De_Segurança_API');
        $database = Database::connect();
        $userRepository = new UserRepository($database);
        $userService = new UserService($userRepository);
        return new UserController(
            userService: $userService,
            json: $json,
            authentication: $authentication,
        );
    }
}
