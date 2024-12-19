<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    // Methodes d'accès aux données dans le repository
    public function createUser(array $data): User;
    public function getUserByEmail(string $email): ?User;
}
