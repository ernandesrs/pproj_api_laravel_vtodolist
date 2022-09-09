<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function index()
    {
        return new UserResource(auth()->user());
    }

    /**
     * @param MeUpdateRequest $request
     * @return UserResource
     */
    public function update(MeUpdateRequest $request)
    {
        $input = $request->validated();
        $user = (new \App\Services\UserService())->update(auth()->user(), $input);
        return (new UserResource($user));
    }
}
