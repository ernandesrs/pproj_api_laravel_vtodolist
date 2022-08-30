<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthLoginRequest $request
     * @return App\Http\Resources\UserResource
     * @throws LoginInvalidException
     */
    public function login(AuthLoginRequest $request)
    {
        $input = $request->validated();
        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    /**
     * @param AuthRegisterRequest $request
     * @return UserResource
     * @throws UserHasBeenTakenException
     */
    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();

        $user = $this->authService->register($input['first_name'], $input['last_name'] ?? '', $input['email'], $input['password']);

        return (new UserResource($user));
    }

    /**
     * @param AuthVerifyEmailRequest $request
     * @return UserResource
     * @throws VerifyEmailTokenInvalidException
     */
    public function verifyEmail(AuthVerifyEmailRequest $request)
    {
        $input = $request->validated();
        $user = $this->authService->verifyEmail($input["token"]);
        return new UserResource($user);
    }

    /**
     * @param AuthForgotPasswordRequest $request
     * @return void
     * @throws ResetPasswordTokenInvalidException
     */
    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $input = $request->validated();
        $this->authService->forgotPassword($input["email"]);
        return;
    }

    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $input = $request->validated();
        $this->authService->resetPassword($input["email"], $input["password"], $input["token"]);
    }
}
