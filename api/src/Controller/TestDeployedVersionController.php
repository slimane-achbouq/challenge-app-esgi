<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class TestDeployedVersionController extends AbstractController
{
    #[Route(
        path: '/api-version',
        name: 'api_version',
        methods: ['GET']
    )]
    public function index(): JsonResponse
    {
        return new JsonResponse(['version' => '1.0.0']);
    }
}
