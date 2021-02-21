<?php

namespace App\DataFixtures;

use App\Entity\User;
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
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [];

        for ($i = 0; $i < 10; $i++) {
            $users[$i] = new User();
            $users[$i]->setUsername('User' . $i);
            $users[$i]->setPassword($this->encoder->encodePassword($users[$i], '123456'));
            $manager->persist($users[$i]);
        }

        $manager->flush();
    }
}
