<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticating User with email and password
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => 'required',
                'remember' => 'boolean',
            ]
        );
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if (!Auth::attempt($credentials, $remember)) {
            return response(
                [
                    'message' => 'Email or password is incorrect',
                ], 422);
        }

        /** @var User $user */
        $user = Auth::user();

        if (!$user->email_verified_at) {
            Auth::logout();

            return response(
                [
                    'message' => 'Your email address is not verified',
                ], 403);
        }

        $token = $user->createToken('main')->plainTextToken;

        return response(
            [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        );
    }

    /**
     * Register/Create new User entity
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $credentials = $request->validate(
            [
                'name' => 'required',
                'email' => ['required', 'email'],
                'password' => 'required',
            ]
        );

        if ($this->isUserWithSuchEmailExists($credentials)) {
            return response(
                [
                    'message' => 'Please try to authenticate. Please, make sure you\'ve confirmed your email address. '
                        . 'If you\'ve forgotten the password, please use the password recovery.',
                ], 422
            );
        }

        $credentials['password'] = bcrypt($credentials['password']);
        $credentials['email_verified_at'] = \now();

        /** @var User $user */
        $f = User::factory();
        $user = $f->create($credentials);

        if (!$user->email_verified_at) {
            Auth::logout();

            return response(
                [
                    'message' => 'Your email address is not verified',
                ], 403);
        }

        $token = $user->createToken('main')->plainTextToken;

        return response(
            [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        );
    }

    /**
     * Logging out User
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }

    /**
     * Fetch authenticated User info.
     *
     * @param Request $request
     *
     * @return UserResource
     */
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    /**
     * Trying to load User with the given email address.
     * In case
     *
     * @param array $credentials
     *
     * @return bool
     */
    private function isUserWithSuchEmailExists(array $credentials): bool
    {
        $user = User::query()
                    ->select(['id', 'email', 'email_verified_at'])
                    ->where('email', '=', $credentials['email'])
                    ->first()
        ;

        return $user instanceof User && $user->id;
    }
}
