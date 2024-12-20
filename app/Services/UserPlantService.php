<?php

namespace App\Services;

use App\Interfaces\UserPlantInterface;
use App\Interfaces\UserPlantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserPlantService implements UserPlantInterface
{
    protected $userPlantRepository;

    public function __construct(UserPlantRepositoryInterface $userPlantRepository)
    {
        $this->userPlantRepository = $userPlantRepository;
    }

    public function createUserPlant(array $data): array
    {
        return $this->userPlantRepository->create($data);
    }

    public function getUserPlants(int $userId): Collection
    {
        return $this->userPlantRepository->findByUserId($userId);
    }

    public function deleteUserPlant(int $userId, int $plantId): bool
    {
        return $this->userPlantRepository->deleteByUserIdAndPlantId($userId, $plantId);
    }
}
