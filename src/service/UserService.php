<?php

namespace Wallet\service;

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
        $user = new User(
            name: $userRequest->name,
            email: $userRequest->email,
            password: $userRequest->password
        );

        $repositoryReturn = $this->userRepository->save(user: $user);

        return new UserResponse(
            id: $repositoryReturn->getId(),
            name: $repositoryReturn->getName(),
            email: $repositoryReturn->getEmail(),
        );
    }

}