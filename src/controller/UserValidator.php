<?php

namespace Wallet\controller;

use Exception;

abstract class UserValidator
{

    protected function validation(
        string $name,
        string $email,
        string $password
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

    protected function sanitization(
        string $name,
        string $email,
        string $password
    ): array {
        $nameSanitize = htmlspecialchars(trim($name), ENT_QUOTES);
        $emailSanitize = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        return [
            'name' => $nameSanitize,
            'email' => $emailSanitize,
            'password' => $password
        ];
    }
}
