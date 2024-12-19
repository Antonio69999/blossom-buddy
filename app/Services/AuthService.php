<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): string
    {
        $user = $this->userRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return $user->createToken('authToken')->plainTextToken;
    }

    public function login(array $data): ?string
    {
        $user = $this->userRepository->getUserByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user->createToken('authToken')->plainTextToken;
    }
}
