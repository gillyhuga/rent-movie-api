<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        if(Auth::check())
        {
            redirect()->route('dashboard.index');
        }
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
            ],
            'password' => [
                'required',
            ],
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json(['success' => false, 'message' => $errors]);
        }

        $token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'user']);
        if(!$token)
        {
            return response()->json(['success' => false, 'message' => ['login' => ['Email dan Password Salah']]]);
        }

        return $this->createToken($token);
    }

    public function logout()
    {
        Auth::logout(); 
        return response()->json(['message' => 'User successfully signed out']);
    }

    protected function createToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }

    public function refresh() {
        return $this->createNewToken(Auth::refresh());
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
            'status' => 'error',
            'success' => false,
            'error' =>
            $validator->errors()->toArray()
            ], 400);
        }
        
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'user',
        ]);
         
        return response()->json([
            'message' => 'User has been created!',
            'user' => $user
            ]);
    }
}