<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Getting user token for accessing to API
     *
     * @Route("/api/user/token", name="user_token", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getToken(Request $request): Response
    {
        $user = $this->getUser();
        $apiToken = md5(uniqid('', true));
        $user->setApiToken($apiToken);
        $this->entityManager->flush();

        return $this->json([
            'api_token' => $apiToken,
        ]);
    }
}
