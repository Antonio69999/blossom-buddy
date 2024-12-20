<?php

namespace App\Services;

use App\Interfaces\PlantInterface;
use App\Interfaces\PlantRepositoryInterface;
use App\Models\Plant;

class PlantService implements PlantInterface
{
    protected $plantRepository;

    public function __construct(PlantRepositoryInterface $plantRepository)
    {
        $this->plantRepository = $plantRepository;
    }

    public function getAllPlants(): array
    {
        return $this->plantRepository->all();
    }

    public function createPlant(array $data): Plant
    {
        return $this->plantRepository->create($data);
    }

    public function getPlantByName(string $name): ?Plant
    {
        return $this->plantRepository->findByName($name);
    }

    public function deletePlantById(int $id): bool
    {
        return $this->plantRepository->deleteById($id);
    }
}
