<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ErrorController extends AbstractController
{
    /**
     * @Route("/api/error", name="error")
     * @param Request $request
     * @param Throwable $exception
     * @param DebugLoggerInterface|null $logger
     *
     * @return Response
     */
    public function index(Request $request, Throwable $exception, ?DebugLoggerInterface $logger): Response
    {
        if (method_exists($exception, 'getStatusCode')) {
            $code = $exception->getStatusCode();
        } else {
            $code = 500;
        }

        $message = 'Something went wrong';

        if (($code >= 400) && ($code < 500)) {
            $message = $exception->getMessage();
        }

        return $this->json([
            'message' => $message,
        ])->setStatusCode($code);
    }
}
