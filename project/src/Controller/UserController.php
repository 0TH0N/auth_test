<?php

namespace App\Controller;

use App\Service\FacadeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Getting user token for accessing to API
     *
     * @Route("/api/user/token", name="user_token", methods={"POST"})
     *
     * @param Request $request
     * @param FacadeService $facadeService
     *
     * @return Response
     */
    public function getToken(Request $request, FacadeService $facadeService): Response
    {
        $user = $this->getUser();
        $apiToken = $facadeService->getNewUserApiToken($user, $request);

        return $this->json([
            'api_token' => $apiToken,
        ]);
    }
}
