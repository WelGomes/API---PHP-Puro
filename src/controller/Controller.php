<?php

namespace Wallet\controller;

use Exception;
use Wallet\dto\request\UserRequest;
use Wallet\dto\response\UserResponse;

abstract class Controller
{

    protected function validationAndSanitization(
        string $name,
        string $email,
        string $password,
        ?int $id = null,
    ): UserRequest {

        $this->validation(
            name: $name,
            email: $email,
            password: $password,
        );

        return $this->sanitization(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
        );
    }

    private function validation(
        string $name,
        string $email,
        string $password,
    ): void {
        
        if (
            empty($name) ||
            empty($email) ||
            empty($password)
        ) {
            throw new Exception("Preencha todos os campos!!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail inválido");
        }
    }

    private function sanitization(
        string $name,
        string $email,
        string $password,
        ?int $id,
    ): UserRequest {

        $nameSanitize = htmlspecialchars(trim($name), ENT_QUOTES);
        $emailSanitize = filter_var(trim($email), FILTER_SANITIZE_EMAIL);

        return new UserRequest(
            id: $id,
            name: $nameSanitize,
            email: $emailSanitize,
            password: $password
        );
    }

    protected function idValidation(mixed $id): int
    {
        if (!is_int($id)) {
            throw new Exception("O Id tem que ser um número inteiro");
        }

        return htmlspecialchars($id, ENT_QUOTES);
    }

    protected function returnAPI(UserResponse $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

}
