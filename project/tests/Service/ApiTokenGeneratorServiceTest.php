<?php

namespace App\Tests\Service;

use App\Service\ApiTokenGeneratorService;
use PHPUnit\Framework\TestCase;

class ApiTokenGeneratorServiceTest extends TestCase
{
    public function testGenerate()
    {
        $apiTokenGeneratorService = new ApiTokenGeneratorService();
        $token = $apiTokenGeneratorService->generate();

        $this->assertIsString($token);
        $this->assertRegExp('/\w{10,}/', $token);
    }
}