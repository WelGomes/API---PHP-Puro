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

        if (!$stmt->execute()) {
            throw new Exception("Error ao cadastrar usuário");
        }

        $user->setId($this->db->lastInsertId());

        return $user;
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare('SELECT id, name, email FROM users');
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (empty($result)) {
            throw new Exception("Error ao buscar usuários  usuário");
        }

        return array_map(
            function (array $users): User {
                return new User(
                    id: $users['id'],
                    name: $users['name'],
                    email: $users['email'],
                    password: 'vazio'
                );
            },
            $result
        );
    }

    public function getUser(int $id): User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new Exception("Usuário não existe");
        }

        return new User(
            id: $result['id'],
            name: $result['name'],
            email: $result['email'],
            password: $result['password']
        );
    }

    public function updateUser(User $user): User
    {
        $stmt = $this->db->prepare('UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id');
        $stmt->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Error ao alterar usuário");
        }

        return $user;
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('Error ao deletar usuário');
        }

        return true;
    }
}
