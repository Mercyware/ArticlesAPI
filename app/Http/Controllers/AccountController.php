<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Interfaces\IUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    //

    /**
     * @var IUserService
     */
    private $userService;

    public function __construct(IUserService $userService)
    {

        $this->userService = $userService;
    }

    public function register(UserRequest $request)
    {
        $user = $this->userService->createUser($request);
        if ($user) {
            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);
        }
        return response()->json([
            'message' => 'Unable to create a new user'
        ], 500);

    }


    public function login(LoginRequest $request)
    {

        $credentials = request(['email', 'password']);

        $token = $this->userService->login($credentials);

        if (!$token)
            return response()->json(['message' => 'Unauthorized'], 401);

        return response()->json([
            "data" => [
                'user_id' => $token->user_id,
                'name' => $token->name,
                'email' => $token->email,
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()]
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}
