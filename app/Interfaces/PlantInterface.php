<?php

namespace App\Interfaces;

use App\Models\Plant;

interface PlantInterface
{
    public function getAllPlants(): array;
    public function createPlant(array $data): Plant;
    public function getPlantByName(string $name): ?Plant;
    public function deletePlantById(int $id): bool;
}
