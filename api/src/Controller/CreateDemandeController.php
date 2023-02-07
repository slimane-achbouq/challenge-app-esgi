<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateDemandeController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(AnnonceRepository $annonceRepository, TokenStorageInterface $tokenStorage): Demande
    {
        $request = $this->requestStack->getCurrentRequest();
        $idAnnonce = $request->get('annonce');
        $annonce = is_numeric($idAnnonce) ? $annonceRepository->findOneBy(['id' => $idAnnonce]) : $idAnnonce;

        $demande = new Demande();
        $demande->setAnnonce($annonce);
        $demande->setDateStart(new \DateTime($request->get('dateStart')));
        $demande->setDateEnd(new \DateTime($request->get('dateEnd')));
        $demande->setLocataire($tokenStorage->getToken()->getUser());

        return $demande;
    }

}
