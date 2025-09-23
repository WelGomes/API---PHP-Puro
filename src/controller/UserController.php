<?php

namespace Wallet\controller;

use Config\Authentication;
use Wallet\service\UserService;

final class UserController extends Controller
{
    private UserService $userService;
    private array $json;
    private Authentication $authentication;

    public function __construct(
        UserService $userService,
        Authentication $authentication,
        array $json,
    ) {
        $this->userService = $userService;
        $this->authentication = $authentication;
        $this->json = $json;
    }

    public function register(): array
    {
        $userSanitize = $this->validationAndSanitization(
            name: $this->json['name'],
            email: $this->json['email'],
            password: $this->json['password'],
        );

        $serviceReturn = $this->userService->register($userSanitize);

        return $this->returnAPI(userResponse: $serviceReturn);
    }

    public function login(): array
    {
        $userSanitize = $this->validationAndSanitization(
            email: $this->json['email'],
            password: $this->json['password']
        );

        $serviceReturn = $this->userService->login($userSanitize);

        $token = $this->authentication->createCryptoLogin(
            id: $serviceReturn->id,
            email: $serviceReturn->email
        );

        return $this->returnAPI(
            userResponse: $serviceReturn,
            token: $token
        );
    }

    public function getAll(): array
    {
        $headers = getallheaders();
        $header = $this->verifyHeader($headers);
        $this->authentication->validateToken(token: $header);
        return $this->userService->getAll();
    }

    public function getUser(): array
    {
        $headers = getallheaders();
        $header = $this->verifyHeader($headers);
        $this->authentication->validateToken(token: $header);

        $serviceReturn = $this->userService->getUser(id: $_GET['id']);

        return $this->returnAPI(userResponse: $serviceReturn);
    }

    public function updateUser(): array
    {
        $headers = getallheaders();
        $header = $this->verifyHeader($headers);
        $this->authentication->validateToken(token: $header);

        $id = $this->idValidation($this->json['id']);

        $userSanitize = $this->validationAndSanitization(
            id: $id,
            name: $this->json['name'],
            email: $this->json['email'],
            password: $this->json['password']
        );

        $serviceReturn = $this->userService->updateUser($userSanitize);

        return $this->returnAPI(userResponse: $serviceReturn);
    }

    public function deleteUser(): array
    {
        $headers = getallheaders();
        $header = $this->verifyHeader($headers);
        $this->authentication->validateToken(token: $header);
        $id = $this->idValidation($this->json['id']);
        $serviceReturn = $this->userService->deleteUser(id: $id);

        return [
            "delete" => $serviceReturn,
        ];
    }
}
