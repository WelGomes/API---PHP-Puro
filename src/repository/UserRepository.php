<?php

namespace Wallet\repository;

use Exception;
use PDO;
use Wallet\model\User;

final class UserRepository implements RepositoryInterface
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(User $user): User
    {
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_ARGON2ID), PDO::PARAM_STR);

        if(!$stmt->execute()) {
            throw new Exception("Error ao cadastrar usuário");
        }

        $user->setId($this->db->lastInsertId());

        return $user;
    }

}