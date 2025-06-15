<?php

namespace App\DTOs\User;

class SignUpUserDto
{
    public function __construct(
        private readonly string $email,
        private string $password,
        private readonly string $name
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            name: $data['name']
        );
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
