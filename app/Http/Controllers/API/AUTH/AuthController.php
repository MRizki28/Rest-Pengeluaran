<?php

namespace App\Http\Controllers\API\AUTH;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RequestStack;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Check Your Valdiation',
                'errors' => $validator->errors() 
            ],Response::HTTP_NOT_ACCEPTABLE);
        }

        $validated = $validator->validated();

        try {
            $data = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        $token = $data->createToken('api-token')->plainTextToken;
        return response()->json([
            'message' => 'success create user',
            'data' => $data,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ],Response::HTTP_OK);
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            
            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'success login',
                'token' => $token
            ]);
        }

        throw ValidationException::withMessages([
            'username' => ['The provided credentials are incorrect.'],
        ]);
    }
}
