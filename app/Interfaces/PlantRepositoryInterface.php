<?php

namespace App\Interfaces;

use App\Models\Plant;

interface PlantRepositoryInterface
{
    public function all(): array;
    public function create(array $data): Plant;
    public function findByName(string $name): ?Plant;
    public function deleteById(int $id): bool;
}
