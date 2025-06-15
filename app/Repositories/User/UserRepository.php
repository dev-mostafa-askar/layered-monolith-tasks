<?php

namespace App\Repositories\User;

use App\DTOs\User\SignUpUserDto;
use App\DTOs\User\UserDto;
use App\Repositories\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function createUser(SignUpUserDto $userDto): UserDto;
    public function findUserByEmail(string $email): UserDto;
}
