<?php

namespace App\Interfaces;

interface AuthInterface
{
    // Methodes liées à l'authentification dans le service
    public function login(array $data): string;
    public function register(array $data): ?string;
}
