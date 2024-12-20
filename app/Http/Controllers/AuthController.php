<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\StoreAuthPostRequest as RegisterRequest;
use App\Http\Requests\StoreLoginRequest as LoginRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Info(title: "Blossom Buddy", version: "0.1")]
#[OA\Schema(
    schema: "RegisterRequest",
    type: "object",
    properties: [
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "password", type: "string")
    ],
    required: ["name", "email", "password"]
)]
#[OA\Schema(
    schema: "LoginRequest",
    type: "object",
    properties: [
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "password", type: "string")
    ],
    required: ["email", "password"]
)]
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[OA\Post(
        path: "/register",
        summary: "Register a new user",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/RegisterRequest")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Successful registration",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "access_token", type: "string"),
                        new OA\Property(property: "token_type", type: "string")
                    ]
                )
            )
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = $this->authService->register($data);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    #[OA\Post(
        path: "/login",
        summary: "Login a user",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/LoginRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful login",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "access_token", type: "string"),
                        new OA\Property(property: "token_type", type: "string")
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Invalid credentials",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string")
                    ]
                )
            )
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = $this->authService->login($data);

        if (!$token) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}
