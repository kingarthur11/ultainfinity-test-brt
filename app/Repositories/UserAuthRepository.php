<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }

    public function login($request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return ['data' => [], 'message' => "Email or password mismatch", 'status' => false];
        }

        $user = Auth::user();
        $response = [];
        $response['token'] = $token;
        $response['user'] = $user;
        return ['data' => $response, 'message' => "User logged in successfully", 'status' => true];

    }

    public function register($request){
        $user = User::where('email', $request->input('email'))->first();
        if($user) 
        {
           return ['data' => [], 'message' => "User already exist", 'status' => false];
        }
        $userData = [
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
        ];
        
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
        $response = [];
        $response['user'] = $user;
        return ['data' => $response, 'message' => "User data saved successfully", 'status' => true];
    }
}
