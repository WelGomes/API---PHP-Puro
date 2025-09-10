<?php

namespace Wallet\dto\response;

final class UserResponse
{

    public function __construct(
        readonly int $id,
        readonly string $name,
        readonly string $email,
    ) {}
}
