<?php

namespace App\Service;

use App\Entity\User;

class DataGeneratorService
{
    public function generate(User $user): string
    {
        return 'Hello, ' . $user->getUsername() . '!';
    }
}