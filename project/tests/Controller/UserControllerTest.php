<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetToken()
    {
        $users = $this->entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        foreach ($users as $user) {
            $this->client->request(
                'POST',
                '/api/user/token',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                '{"username":"' . $user->getUsername() . '", "password":"123456"}'
            );

            $response = $this->client->getResponse();

            $this->entityManager->refresh($user);

            $this->assertResponseIsSuccessful();
            $this->assertJson($response->getContent());

            $responseBody = json_decode($response->getContent(), true);

            $this->assertArrayHasKey('api_token', $responseBody);
            $this->assertEquals($user->getApiToken(), $responseBody['api_token']);
        }
    }
}