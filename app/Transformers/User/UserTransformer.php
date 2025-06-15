<?php

namespace App\Transformers\User;


use App\DTOs\User\UserDto;
use Flugg\Responder\Transformers\Transformer;

class UserTransformer extends Transformer
{
    /**
     * Transform the DTO.
     *
     * @param  \App\DTOs\User\UserDto $userDto
     * @return array
     */
    public static function transform(UserDto $userDto)
    {
        $user = $userDto->getUser();
        return [
            'user' => [
                'id' => (int) $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $userDto->getToken()
        ];
    }
}
