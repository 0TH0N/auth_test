<?php

namespace App\Service;

use App\Entity\User;

/**
 * Service for generating 'useful' data.
 *
 * @package App\Service
 */
class DataGeneratorService
{
    public function generate(User $user): string
    {
        return 'Hello, ' . $user->getUsername() . '!';
    }
}