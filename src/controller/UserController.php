<?php

namespace Wallet\controller;

use Wallet\service\UserService;

final class UserController extends Controller
{
    private UserService $userService;
    private array $json;

    public function __construct(UserService $userService, array $json)
    {
        $this->userService = $userService;
        $this->json = $json;
    }

    public function save(): array
    {
        $userSanitize = $this->validationAndSanitization(
            name: $this->json['name'],
            email: $this->json['email'],
            password: $this->json['password'],
        );

        $serviceReturn = $this->userService->save($userSanitize);

        return $this->returnAPI($serviceReturn);
    }

    public function getAll(): array
    {
        return $this->userService->getAll();
    }

    public function getUser(): array
    {
        $id = $this->idValidation((int)$_GET['id']);

        $serviceReturn = $this->userService->getUser(id: $id);

        return $this->returnAPI($serviceReturn);
    }

    public function updateUser(): array
    {
        $id = $this->idValidation($this->json['id']);

        $userSanitize = $this->validationAndSanitization(
            id: $id,
            name: $this->json['name'],
            email: $this->json['email'],
            password: $this->json['password']
        );

        $serviceReturn = $this->userService->updateUser($userSanitize);

        return $this->returnAPI($serviceReturn);
    }

    public function deleteUser(): array
    {
        $id = $this->idValidation($this->json['id']);

        $serviceReturn = $this->userService->deleteUser(id: $id);

        return [
            'delete' => $serviceReturn,
        ];
    }

}
