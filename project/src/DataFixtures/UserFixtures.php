<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\ApiTokenGeneratorService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var ApiTokenGeneratorService
     */
    private $apiTokenGeneratorService;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param ApiTokenGeneratorService $apiTokenGeneratorService
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        ApiTokenGeneratorService $apiTokenGeneratorService
    ) {
        $this->encoder = $encoder;
        $this->apiTokenGeneratorService = $apiTokenGeneratorService;
    }

    public function load(ObjectManager $manager)
    {
        $users = [];

        for ($i = 0; $i < 10; $i++) {
            $users[$i] = new User();
            $users[$i]->setUsername('User' . $i);
            $users[$i]->setPassword($this->encoder->encodePassword($users[$i], '123456'));
            $users[$i]->setApiToken($this->apiTokenGeneratorService->generate());
            $manager->persist($users[$i]);
        }

        $manager->flush();
    }
}
