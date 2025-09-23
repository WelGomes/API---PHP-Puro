<?php

namespace Wallet\repository;

use Wallet\model\User;

interface RepositoryInterface
{
    function register(User $user): User;
    function login(User $user): User;
    function getAll(): array;
    function getUser(int $id): User;
    function updateUser(User $user): User;
    function deleteUser(int $id): bool;
}
