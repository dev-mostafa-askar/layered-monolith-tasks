<?php

namespace App\DTOs\User;

use App\Models\User;

class UserDto
{

    private $token = null;
    public function __construct(
        private readonly User $user,
    ) {}

    public static function fromArray(User $user): self
    {
        return new self(
            user: $user
        );
    }

    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
