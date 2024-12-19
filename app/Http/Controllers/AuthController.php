<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\StoreAuthPostRequest as Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        // Validation des données
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Enregistrer l'utilisateur et générer le token
        $token = $this->authService->register($data);

        // Retourner la réponse avec la structure demandée
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        // Validation des données
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Authentifier l'utilisateur et générer le token
        $token = $this->authService->login($data);

        // Si le token est nul (identifiants incorrects), retourner une erreur
        if (!$token) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Retourner la réponse avec la structure demandée
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}
