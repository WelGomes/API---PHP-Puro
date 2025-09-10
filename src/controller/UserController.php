<?php

namespace Wallet\controller;

use Wallet\dto\request\UserRequest;
use Wallet\service\UserService;

final class UserController extends UserValidator
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function save(): array
    {
        $json = json_decode(file_get_contents("php://input"), true);

        $this->validation(
            name: $json['name'],
            email: $json['email'],
            password: $json['password']
        );

        $userCrypto = $this->sanitization(
            name: $json['name'],
            email: $json['email'],
            password: $json['password']
        );

        $userRequest = new UserRequest(
            name: $userCrypto['name'],
            email: $userCrypto['email'],
            password: $userCrypto['password']
        );

        $serviceReturn = $this->userService->save($userRequest);

        return [
            'Id' => $serviceReturn->id,
            'name' => $serviceReturn->name,
            'email' => $serviceReturn->email,
        ];
    }
}
