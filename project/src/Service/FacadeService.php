<?php

namespace App\Service;

use App\Entity\User;
use App\Validator\RequestForUserApiToken;
use App\Validator\StringToDateTime;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * This class used for encapsulating some actions for validation inner request,
 * generating new token and save it in a database.
 *
 * @package App\Security
 */
class FacadeService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var RequestForUserApiToken
     */
    private $requestForUserApiToken;

    /**
     * @var StringToDateTime
     */
    private $stringToDateTime;

    /**
     * @var ApiTokenGeneratorService
     */
    private $apiTokenGeneratorService;

    /**
     * FacadeService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param RequestForUserApiToken $requestForUserApiToken
     * @param StringToDateTime $stringToDateTime
     * @param ApiTokenGeneratorService $apiTokenGeneratorService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        RequestForUserApiToken $requestForUserApiToken,
        StringToDateTime $stringToDateTime,
        ApiTokenGeneratorService $apiTokenGeneratorService
    ) {

        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->requestForUserApiToken = $requestForUserApiToken;
        $this->stringToDateTime = $stringToDateTime;
        $this->apiTokenGeneratorService = $apiTokenGeneratorService;
    }

    public function getNewUserApiToken(User $user, Request $request): string
    {
        $this->validator->validate($request, $this->requestForUserApiToken);
        $userTimestamp = json_decode($request->getContent(), true)['timestamp'];
        $this->validator->validate($userTimestamp, $this->stringToDateTime);
        $userTimestamp = new DateTime($userTimestamp);
        $serverTimestamp = new DateTime();
        $token = $this->apiTokenGeneratorService->generate();

        $user->setApiToken($token)
            ->setUserTimeApiTokenRequest($userTimestamp)
            ->setServerTimeApiTokenRequest($serverTimestamp);

        $this->entityManager->flush();

        return $token;
    }
}