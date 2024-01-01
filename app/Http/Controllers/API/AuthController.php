<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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
        if($user->status == 2) {
            auth('api')->logout();
            return response()->json([
                'message' => 'Your account is locked'
            ]);
        }
        return $this->respondWithToken($token);
        
    }

    public function profile() {
        if(auth('api')->user()) {
            return response()->json([
                'email' => auth('api')->user()->email,
                'full_name' => auth('api')->user()->full_name,
                'phone' => auth('api')->user()->phone,
                'address' => auth('api')->user()->address,
                'level' => auth('api')->user()->level,
                'status' => auth('api')->user()->status,
            ],200); 
        }
        else {
            return response()->json([
                'message' => 'You need to login to get profile'
            ]);
        }
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60

        ]);
    }

    public function edit_profile(Request $request) {
        if(auth('api')->user()) {
            $infoAfterEdit = [
                'address' => $request->address,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
            ];
            User::where('id',auth('api')->user()->id)->update($infoAfterEdit);
            return response()->json([
                'message' => 'Edit successfully'
            ],200);
        } 
        return response()->json([
            'message' => 'Error'
        ],401);
    }

    public function change_password(Request $request) {
        $user_current_password = User::where('id', auth('api')->user()->id)->first();
        if(Hash::check($request->current_password, $user_current_password->password)) {
            $new_password = $request->password;
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8'
                ], [
                'current_password.required' => 'Please enter your current password',
                'password.required' => 'Please enter your new password',
                'password.confirmed' => 'Password confirmation is not correct'  
                ]);
                
            $new_password = ['password' => bcrypt($request->password)];
            User::where('id',auth('api')->user()->id)->update($new_password);
            if($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            return response()->json([
                'message' => 'Change password successfully'
            ]);
        }
        else {
            return response()->json([
                'message' => 'Current password is not correct',
                'status_code' => '404'
            ]);
        }
    }
}
