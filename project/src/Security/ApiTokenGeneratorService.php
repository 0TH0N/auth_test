<?php

namespace App\Security;

class ApiTokenGeneratorService
{
    public function generate(): string
    {
        return md5(uniqid('', true));
    }
}