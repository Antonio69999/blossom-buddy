<?php

namespace App\Http\Controllers;

use App\Interfaces\UserPlantInterface;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use App\Http\Requests\StoreUserPlantRequest;


class UserPlantController extends Controller
{
    protected $userPlantService;

    public function __construct(UserPlantInterface $userPlantService)
    {
        $this->userPlantService = $userPlantService;
    }

    #[OA\Post(
        path: "/user-plants",
        summary: "Add a plant to the user's collection",
        tags: ["UserPlants"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "plant_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Plant added successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "integer"),
                        new OA\Property(property: "user_id", type: "integer"),
                        new OA\Property(property: "plant_id", type: "integer")
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation error",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string")
                    ]
                )
            )
        ]
    )]
    public function store(StoreUserPlantRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $userPlant = $this->userPlantService->createUserPlant($data);

        return response()->json($userPlant, 201);
    }

    #[OA\Get(
        path: "/user-plants",
        summary: "Get all plants in the user's collection",
        tags: ["UserPlants"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of user plants",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer"),
                            new OA\Property(property: "user_id", type: "integer"),
                            new OA\Property(property: "plant_id", type: "integer")
                        ]
                    )
                )
            )
        ]
    )]
    public function index()
    {
        $user = Auth::user();
        $userPlants = $this->userPlantService->getUserPlants($user->id);

        return response()->json($userPlants);
    }

    #[OA\Delete(
        path: "/user-plants/{id}",
        summary: "Remove a plant from the user's collection",
        tags: ["UserPlants"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Plant deleted successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Plant not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string")
                    ]
                )
            )
        ]
    )]
    public function destroy($id)
    {
        $user = Auth::user();
        $deleted = $this->userPlantService->deleteUserPlant($user->id, $id);

        if (!$deleted) {
            return response()->json(['error' => 'Plant not found'], 404);
        }

        return response()->json(['message' => 'Plant deleted successfully']);
    }
}
