<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->setTTL(7200)->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $jwt = $this->createNewToken($token);

        //user jwt to session
        $request->session()->put('jwt', $token);

        return $jwt;
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
    $data = new User;
    $validator = $request->validate([
        'name' => 'required|max:20|min :6',
        'address' => 'required|max:300| min:15',
        'phone' => 'required|regex:/^(601)[0-46-9]*[0-9]{7,8}$/',
        'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        'confirmed_password' => 'required|same:password',
        'email' => 'required | regex:/^[a-zA-Z0-9]+@(?:[a-zA-Z0-9]+\.)+[com]+$/|unique:users',
        'role' => 'in:admin,user'
    ]);

    $data->name = $request->name;
    $data->address = $request->address;    
    $data->phone = $request->phone;
    $data->email = $request->email;    
    $data->password = Hash::make($request->password);
    $data->role = $request->role;    
    $data -> save();
    return response()->json([
        'message' => 'User successfully registered',
        'user' => $data
    ], 201);

    }
    
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
