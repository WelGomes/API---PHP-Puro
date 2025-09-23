<?php

namespace Wallet\dto\request;

final class UserRequest
{
    public function __construct(
        readonly ?int $id,
        readonly ?string $name,
        readonly string $email,
        readonly string $password,
    ) {}
}
