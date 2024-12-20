<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function getUserByName(string $name): ?User
    {
        return User::where('name', $name)->first();
    }
}
