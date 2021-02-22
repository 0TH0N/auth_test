<?php

namespace App\Service;

/**
 * Service for generating API Token for users
 *
 * @package App\Service
 */
class ApiTokenGeneratorService
{
    public function generate(): string
    {
        return md5(uniqid('', true));
    }
}