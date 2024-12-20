<?php

namespace App\Repositories;

use App\Interfaces\UserPlantRepositoryInterface;
use App\Models\UserPlant;
use Illuminate\Database\Eloquent\Collection;

class UserPlantRepository implements UserPlantRepositoryInterface
{
    public function create(array $data): array
    {
        UserPlant::create($data);
        return $data;
    }

    public function findByUserId(int $userId): Collection
    {
        return UserPlant::where('user_id', $userId)->get();
    }

    public function deleteByUserIdAndPlantId(int $userId, int $plantId): bool
    {
        return UserPlant::where('user_id', $userId)
            ->where('plant_id', $plantId)
            ->delete() > 0;
    }
}
