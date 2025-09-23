<?php

namespace Wallet\controller;

use Exception;
use Wallet\dto\request\UserRequest;
use Wallet\dto\response\UserResponse;

abstract class Controller
{

    protected function validationAndSanitization(
        string $email,
        string $password,
        ?string $name = null,
        ?int $id = null,
    ): UserRequest {

        if (!empty($name)) {
            $this->validationRegister(
                name: $name,
                email: $email,
                password: $password,
            );
        }

        if (empty($name)) {
            $this->validationLogin(
                email: $email,
                password: $password
            );
        }

        return $this->sanitization(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
        );
    }

    private function validationRegister(
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

    private function validationLogin(
        string $email,
        string $password
    ): void {
        if (empty($email) || empty($password)) {
            throw new Exception("Preencha todos os campos!!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail inválido");
        }
    }

    private function sanitization(
        string $email,
        string $password,
        ?string $name,
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

    protected function returnAPI(
        UserResponse $userResponse,
        ?string $token = null
    ): array {

        return empty($token) ? [
            "id" => $userResponse->id,
            "name" => $userResponse->name,
            "email" => $userResponse->email,
        ] :
            [
                "id" => $userResponse->id,
                "name" => $userResponse->name,
                "email" => $userResponse->email,
                "token" => $token,
            ];
    }

    protected function verifyHeader(array $header): string
    {
        if (!isset($header["Authorization"])) {
            throw new Exception("Não se encontra nenhuma chave de token no header");
        }

        return $header["Authorization"];
    }
}
