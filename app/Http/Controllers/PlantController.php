<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlantRequest;
use App\Interfaces\PlantInterface;
use OpenApi\Attributes as OA;

class PlantController extends Controller
{
    protected $plantService;

    public function __construct(PlantInterface $plantService)
    {
        $this->plantService = $plantService;
    }

    #[OA\Get(
        path: "/plants",
        summary: "Get all plants",
        tags: ["Plants"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of plants",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer"),
                            new OA\Property(property: "common_name", type: "string"),
                            new OA\Property(property: "watering_general_benchmark", type: "string")
                        ]
                    )
                )
            )
        ]
    )]
    public function index()
    {
        return $this->plantService->getAllPlants();
    }

    #[OA\Post(
        path: "/plants",
        summary: "Create a new plant",
        tags: ["Plants"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "common_name", type: "string", example: "Rose"),
                    new OA\Property(property: "watering_general_benchmark", type: "string", example: "{\"frequency\": \"weekly\"}")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Plant created successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "integer"),
                        new OA\Property(property: "common_name", type: "string"),
                        new OA\Property(property: "watering_general_benchmark", type: "string")
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

    public function store(StorePlantRequest $request)
    {
        $data = $request->validated();

        $plant = $this->plantService->createPlant($data);

        return response()->json($plant, 201);
    }

    #[OA\Get(
        path: "/plants/{name}",
        summary: "Get a plant by name",
        tags: ["Plants"],
        parameters: [
            new OA\Parameter(
                name: "name",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Plant details",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "integer"),
                        new OA\Property(property: "common_name", type: "string"),
                        new OA\Property(property: "watering_general_benchmark", type: "string")
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
    public function show($name)
    {
        $plant = $this->plantService->getPlantByName($name);

        if (!$plant) {
            return response()->json(['error' => 'Plant not found'], 404);
        }

        return response()->json($plant);
    }

    #[OA\Delete(
        path: "/plants/{id}",
        summary: "Delete a plant by ID",
        tags: ["Plants"],
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
        $deleted = $this->plantService->deletePlantById($id);

        if (!$deleted) {
            return response()->json(['error' => 'Plant not found'], 404);
        }

        return response()->json(['message' => 'Plant deleted successfully']);
    }
}
