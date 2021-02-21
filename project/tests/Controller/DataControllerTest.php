<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DataControllerTest extends WebTestCase
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

    public function testGetData()
    {
        $users = $this->entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        foreach ($users as $user) {
            $this->client->request(
                'GET',
                '/api/data',
                [],
                [],
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_X-AUTH-TOKEN' => $user->getApiToken(),
                ]
            );

            $response = $this->client->getResponse();

            $this->assertResponseIsSuccessful();
            $this->assertJson($response->getContent());

            $responseBody = json_decode($response->getContent(), true);

            $this->assertArrayHasKey('message', $responseBody);
            $this->assertEquals('Hello, ' . $user->getUsername() . '!', $responseBody['message']);
        }
    }
}