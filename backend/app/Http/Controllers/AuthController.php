<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AuthController
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->auth($request);
    }

    /**
     * Register a User.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create(array_merge(
            $request->validated(),
            ['password' => bcrypt($request->password)]
        ));

        if ((bool)config('auth.login_after_signup')) {
            return $this->auth($request);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully registered',
            'user'    => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'status'  => 'success',
            'message' => 'User successfully signed out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->responseNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    private function auth(Request $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json([
                'status' => 'error',
                'error'  => 'Invalid Email or Password'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->responseNewToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function responseNewToken(string $token)
    {
        return response()->json([
            'status'       => 'success',
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user()
        ], Response::HTTP_OK);
    }

}
