<?php

namespace App\Services\User;

use App\DTOs\User\SignInUserDto;
use App\DTOs\User\SignUpUserDto;
use App\DTOs\User\UserDto;
use App\Repositories\User\UserRepository;
use Flugg\Responder\Exceptions\Http\UnauthenticatedException;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function __construct(private UserRepository $userRepository) {}

    public function signUp(SignUpUserDto $userDto): UserDto
    {
        $userDto->setPassword(Hash::make($userDto->getPassword()));
        $userDto = $this->userRepository->createUser($userDto);
        $user = $userDto->getUser();
        $token = $user->createToken('access_token')->accessToken;
        $userDto->setToken($token);
        return $userDto;
    }

    public function signIn(SignInUserDto $dto): UserDto
    {
        $userDto = $this->userRepository->findUserByEmail($dto->getEmail());
        $user = $userDto->getUser();

        if (! $user || ! Hash::check($dto->getPassword(), $user->password)) {
            throw new UnauthenticatedException('Credentials are incorrect');
        }

        $token = $user->createToken('access_token')->accessToken;
        $userDto->setToken($token);
        return $userDto;
    }
}
