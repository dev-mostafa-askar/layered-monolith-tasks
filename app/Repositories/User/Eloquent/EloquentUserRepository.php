<?php

namespace App\Repositories\User\Eloquent;

use App\DTOs\User\SignUpUserDto;
use App\DTOs\User\UserDto;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\User\UserRepository;
use Flugg\Responder\Exceptions\Http\UnauthenticatedException;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{

    public function createUser(SignUpUserDto $userDto): UserDto
    {
        $user = $this->create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'password' => $userDto->getPassword()
        ]);

        return UserDto::fromArray($user);
    }

    public function findUserByEmail(string $email): UserDto
    {
        $user = $this->findByEmail($email);
        if (!$user) {
            throw new UnauthenticatedException('Credentials are incorrect');
        }
        return UserDto::fromArray($user);
    }
}