<?php

namespace App\Tests\Controller;

use App\Entity\User;
use DateInterval;
use DateTime;
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

        $userTimestamp = (new DateTime())->format('Y-m-d H:i:s');

        // Bunch of successful requests
        foreach ($users as $user) {
            $jsonBody = '{"username":"' . $user->getUsername() .
                '", "password":"123456", "timestamp":"' . $userTimestamp . '"}';

            $this->client->request(
                'POST',
                '/api/user/token',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                $jsonBody
            );

            $response = $this->client->getResponse();

            $this->entityManager->refresh($user);

            $this->assertResponseIsSuccessful();
            $this->assertJson($response->getContent());

            $responseBody = json_decode($response->getContent(), true);

            $this->assertArrayHasKey('api_token', $responseBody);
            $this->assertEquals($user->getApiToken(), $responseBody['api_token']);
        }


        // Wrong request because difference between server and user timestamps too large (1 second)
        $userTimestamp = (new DateTime())->sub(new DateInterval('P1DT1S'))->format('Y-m-d H:i:s');
        $jsonBody = '{"username":"' . $user->getUsername() .
            '", "password":"123456", "timestamp":"' . $userTimestamp . '"}';

        $this->client->request(
            'POST',
            '/api/user/token',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonBody
        );

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(400);
        $this->assertJson($response->getContent());

        $responseBody = json_decode($response->getContent(), true);
        $expectedString = 'User DateTime has difference with server DateTime more than 24 hours.';

        $this->assertArrayHasKey('message', $responseBody);
        $this->assertEquals($expectedString, $responseBody['message']);

    }
}