<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testGetToken()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/user/token',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"name":"User0", "password":"123456"}'
        );

        $this->assertResponseIsSuccessful();
    }
}