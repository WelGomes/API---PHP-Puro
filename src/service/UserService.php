<?php

namespace Wallet\service;

use Exception;
use Wallet\dto\request\UserRequest;
use Wallet\dto\response\UserResponse;
use Wallet\model\User;
use Wallet\repository\RepositoryInterface;

final class UserService
{

    private RepositoryInterface $userRepository;

    public function __construct(RepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(UserRequest $userRequest): UserResponse
    {
        $user = $this->returnUser(userRequest: $userRequest);

        $repositoryReturn = $this->userRepository->save(user: $user);

        return $this->returnUserResponse(user: $repositoryReturn);
    }

    public function getAll(): array
    {
        $users = $this->userRepository->getAll();

        if (empty($users)) {
            throw new Exception('Lista veio vázia');
        }

        return array_map(
            function (User $user): UserResponse {
                return $this->returnUserResponse(user: $user);
            },
            $users
        );
    }

    public function getUser(int $id): UserResponse
    {
        $user = $this->userRepository->getUser(id: $id);

        if (empty($user)) {
            throw new Exception('BD veio vazia');
        }

        return $this->returnUserResponse(user: $user);
    }

    public function updateUser(UserRequest $userRequest): UserResponse
    {
        $user = $this->returnUser(userRequest: $userRequest);

        $this->userRepository->getUser(id: $user->getId());

        $userRepository = $this->userRepository->updateUser(user: $user);

        return $this->returnUserResponse(user: $userRepository);
    }

    public function deleteUser(int $id): bool
    {
        $this->userRepository->getUser(id: $id);
        return $this->userRepository->deleteUser(id: $id);
    }

    private function returnUser(UserRequest $userRequest): User
    {
        return new User(
            id: $userRequest->id,
            name: $userRequest->name,
            email: $userRequest->email,
            password: $userRequest->password
        );
    }

    private function returnUserResponse(User $user): UserResponse
    {
        return new UserResponse(
            id: $user->getId(),
            name: $user->getName(),
            email: $user->getEmail(),
        );
    }
}
