<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\DTOs\User\SignInUserDto;
use App\DTOs\User\SignUpUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInUserRequest;
use App\Http\Requests\Auth\SignUpUserRequest;
use App\Services\User\UserService;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Response;

class AuthUserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function signUp(SignUpUserRequest $request)
    {
        $userDto = SignUpUserDto::fromArray($request->validated());
        $userDto = $this->userService->signUp($userDto);
        return responder()->success($userDto, UserTransformer::class)->respond(Response::HTTP_CREATED);
    }

    public function signIn(SignInUserRequest $request)
    {
        $userDto = SignInUserDto::fromArray($request->validated());
        $userDto = $this->userService->signIn($userDto);
        return responder()->success($userDto, UserTransformer::class)->respond(Response::HTTP_OK);
    }
}
