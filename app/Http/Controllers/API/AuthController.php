<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'profile']]);
    }

    public function register(RegisterRequest $request) {
                // Use request default of laravel
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|confirmed|min:6'
        // ], [
        //     'email.required' => 'Please enter your email',
        //     'email.email' => 'It\'s not an email',
        //     'email.unique' => 'This email was exist',
        //     'password.required' => 'Please enter your password',
        //     'password.confirmed' => 'Password confirmation is not correct',
        //     'password.min' => 'Password must be at least 6 charactors',
        // ]);

        // if($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()],400);
        // }

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        
        return response()->json([
            'message' => 'User successfully registered',
        ],201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->all();
                // Use the default request of laravel
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required|min:6'
        // ], [
        //     'email.required' => 'Please enter your email',
        //     'email.email' => 'It\'s not an email',
        //     'password.required' => 'Please enter your password',
        //     'password.min' => 'Password must be at least 6 charactors',
        // ]);

        // if($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 422);
        // }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth('api')->user();
        if($user->level == 1) {
            auth('api')->logout();
            return response()->json(['error' => 'Not found'], 403);
        }
        return $this->respondWithTokenAndProfile($token);
        
    }

    // public function profile() {
    //         return response()->json([
    //             'email' => auth('api')->user()->email,
    //             'full_name' => auth('api')->user()->full_name,
    //             'phone' => auth('api')->user()->phone,
    //             'address' => auth('api')->user()->address,
    //             'level' => auth('api')->user()->level,
    //             'status' => auth('api')->user()->status,
    //         ],200);
    // }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithTokenAndProfile($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'email' => auth('api')->user()->email,
            'full_name' => auth('api')->user()->full_name,
            'phone' => auth('api')->user()->phone,
            'address' => auth('api')->user()->address,
            'level' => auth('api')->user()->level,
            'status' => auth('api')->user()->status,

        ]);
    }

    public function edit_profile(Request $request) {
        if(auth('api')->user()) {
            $infoAfterEdit = [
                'address' => $request->address,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
            ];
            $password = $request->password;
            if(!empty($password)) {
                $validator = Validator::make($request->all(), [
                'password' => 'confirmed'
                ], [
                'password.confirmed' => 'Password confirmation is not correct'  
                ]);
            
                $infoAfterEdit = ['password' => bcrypt($request->password)];
                if($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 422);
                }
            }
            User::where('id',auth('api')->user()->id)->update($infoAfterEdit);
            return response()->json([
                'message' => 'Edit successfully'
            ],200);
        }
        
        return response()->json([
            'message' => 'Error'
        ],401);
    }
}
