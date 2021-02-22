<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\DataGeneratorService;
use PHPUnit\Framework\TestCase;

class DataGeneratorServiceTest extends TestCase
{
    public function testGenerate()
    {
        $user = new User();
        $user->setUsername('Trump');
        $dataGeneratorService = new DataGeneratorService();
        $data = $dataGeneratorService->generate($user);

        $this->assertEquals('Hello, ' . $user->getUsername() . '!', $data);
    }
}