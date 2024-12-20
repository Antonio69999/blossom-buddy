<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserPlantRepositoryInterface
{
    public function create(array $data): array;
    public function findByUserId(int $userId): Collection;
    public function deleteByUserIdAndPlantId(int $userId, int $plantId): bool;
}
