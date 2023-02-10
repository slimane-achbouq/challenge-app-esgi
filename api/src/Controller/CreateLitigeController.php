<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Litige;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateLitigeController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(AnnonceRepository $annonceRepository, TokenStorageInterface $tokenStorage): Litige
    {
        $request = $this->requestStack->getCurrentRequest();
        $uploadedFile = $request->files->get('file');

        $idAnnonce = $request->get('annonce');
        $annonce = is_numeric($idAnnonce) ? $annonceRepository->findOneBy(['id' => $idAnnonce]) : $idAnnonce;

        $litige = new Litige();
        if ($request->get('otherReason')) {
            $litige->setRaison($request->get('otherReason'));
        }
        else {
            $litige->setRaison($request->get('reason'));
        }
        if ($uploadedFile) {
            $litige->setFile($uploadedFile);
            $litige->setImage($uploadedFile->getClientOriginalName());
        }
        $litige->setAnnonce($annonce);
        $litige->setDescription($request->get('description'));
        $litige->setStatus(0);
        $litige->setCreatedAt(new \DateTimeImmutable());
        $litige->setLocataire($tokenStorage->getToken()->getUser());

        return $litige;
    }

}
