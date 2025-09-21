<?php

namespace Config;

use Exception;

class Routes
{

    private function load(string $className, string $methodName): array
    {
        $fileName = "\\Wallet\\controller\\{$className}";

        if (!class_exists($fileName)) {
            throw new Exception("Diretorio não existe {$fileName}");
        }

        $class = $this->injectionDependency($className);

        $newClass = $class();

        if (!method_exists($newClass, $methodName)) {
            throw new Exception("Método do controller não existe");
        }

        return $newClass->$methodName();
    }

    public function routes(string $uri, string $resquest): array
    {
        $routes = [
            'POST' => [
                '/' => fn() => $this->load("UserController", "save"),
            ],
            'GET' => [
                '/' => fn() => $this->load("UserController", "getUser"),
                '/all' => fn() => $this->load("UserController", "getAll"),
            ],
            'PUT' => [
                '/' => fn() => $this->load("UserController", "updateUser")
            ],
            'DELETE' => [
                '/delete' => fn() => $this->load("UserController", "deleteUser")
            ]
        ];

        if (!array_key_exists($resquest, $routes)) {
            throw new Exception("Requisição não existe");
        }

        if (!array_key_exists($uri, $routes[$resquest])) {
            throw new Exception("Path não existe");
        }

        return $routes[$resquest][$uri]();
    }

    private function injectionDependency(string $class): callable
    {
        return match($class) {
            'UserController' => fn() => Container::getUserController(),
            default => throw new Exception("Controller {$class} não configurado no container.")
        };
    }
}
