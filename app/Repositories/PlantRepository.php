<?php

namespace App\Repositories;

use App\Interfaces\PlantRepositoryInterface;
use App\Models\Plant;

class PlantRepository implements PlantRepositoryInterface
{
    public function all(): array
    {
        return Plant::all()->toArray();
    }

    public function create(array $data): Plant
    {
        return Plant::create($data);
    }

    public function findByName(string $name): ?Plant
    {
        return Plant::where('common_name', $name)->first();
    }

    public function deleteById(int $id): bool
    {
        $plant = Plant::find($id);
        if ($plant) {
            return $plant->delete();
        }
        return false;
    }
}
