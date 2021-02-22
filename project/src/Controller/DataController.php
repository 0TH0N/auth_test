<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\DataGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    /**
     * @var DataGeneratorService
     */
    private $dataGeneratorService;

    /**
     * DataController constructor.
     *
     * @param DataGeneratorService $dataGeneratorService
     */
    public function __construct(DataGeneratorService $dataGeneratorService)
    {
        $this->dataGeneratorService = $dataGeneratorService;
    }

    /**
     * @Route("/api/data", name="data", methods={"GET"})
     */
    public function getData(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $data = $this->dataGeneratorService->generate($user);

        return $this->json([
            'message' => $data,
        ]);
    }
}
