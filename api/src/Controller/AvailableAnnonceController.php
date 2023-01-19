<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use ApiPlatform\Doctrine\Orm\Paginator;

#[AsController]
class AvailableAnnonceController extends AbstractController
{
    public function __invoke(Request $request, AnnonceRepository $annonceRepository): Paginator
    {
        $page = (int)$request->get('page');
        return $annonceRepository->getAvailableAnnonces($page);
    }
}
