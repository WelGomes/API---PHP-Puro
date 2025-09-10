<?php

namespace Wallet\repository;

use Wallet\model\User;

interface RepositoryInterface {
    function save(User $user): User;
}