<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserPlantInterface
{
    public function createUserPlant(array $data): array;
    public function getUserPlants(int $userId): Collection;
    public function deleteUserPlant(int $userId, int $plantId): bool;
}
