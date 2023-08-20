<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        try{
            $rules = [
                "name" => "required|string|min:2|max:10",
                "email" => "required|string|unique:users",
                "password" => "required|string|min:8"
            ];

            $messages = [
                'username.required' => 'The username field is required.',
                'username.min' => 'The username must be at least :min characters.',
                'username.max' => 'The username may not be greater than :max characters.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email address is already registered.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least :min characters.',
                'password.confirmed' => 'The password confirmation does not match.',
            ];

            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => Hash::make($request->get("password"))
            ];

            $validator = Validator::make($data, $rules, $messages);

            if ( $validator->fails() )
            {
                return response()->json([
                    "success" => false,
                    "message" => $validator->error()
                ], 403);
            }

            $existingUser = User::where("email", $data["email"])->first();

            if ( !$existingUser ) {
                $user = User::create($data);
                return response()->json([
                    "success" => true,
                    "data" => $user,
                    "message" => "User created!"
                ], 201);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "User already exists"
                ], 401);
            }

        } catch(Exception $e){
            return response()->json([
                "success" => true,
                "message" => $e->getMessage() 
            ], 500);
        }
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            "user" => auth()->user()
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}