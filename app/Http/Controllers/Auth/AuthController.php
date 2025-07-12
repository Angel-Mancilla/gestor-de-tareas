<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
    public function create(CreateRequest $request)
    {   
        try {
            $requestValidated = $request->validated();
            $userValidated = [
                'name' => $requestValidated['name'],
                'email' => $requestValidated['email'],
                'password' => Hash::make($requestValidated['password']),
            ];
            $user = User::create($userValidated);
            return response()->json([
                'status' => 'Successuful',
                'message' => 'Se ha creado exitosamente el usuario',
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Failed',
                'error' => true,
                'message' => 'No se pudo crear al usuario '+$th->getMessage()
            ],500);
        }
        
    }

    public function login(LoginRequest $request)
    {
        $requestValidated = $request->validated();

        $credentials = [
            'email' => $requestValidated['email'],
            'password' => $requestValidated['password'], 
        ];

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'Unauthorized',
                'message' => 'No se pudo iniciar sesion, sus credenciales son invalidas'
            ],401);
        }

        $request->session()->regenerate();
        // $user = Auth::user();
        // $tokenUser = $user->createToken($requestValidated['device'])->plainTextToken;
        return response()->json([
            'status' => 'Authorized',
            'message' => 'Se ha iniciado sesion de forma exitosa',
            // 'token' => $tokenUser
        ],200);
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        // $request->user()->currentAccessToken()->delete();
            return response()->json([
            'message' => 'Se ha cerrado la sesion correctamente'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
             'message' => 'Ha ocurrido un error inesperado '+ $th->getMessage()
            ],500);
        }
        
    }
}
