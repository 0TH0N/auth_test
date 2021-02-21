<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    /**
     * @Route("/api/data", name="data", methods={"GET"})
     */
    public function getData(): Response
    {
        $user = $this->getUser();

        return $this->json([
            'message' => 'Hello, ' . $user->getUsername() . '!',
        ]);
    }
}
