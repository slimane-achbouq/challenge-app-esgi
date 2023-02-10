<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Litige;
use App\Repository\AnnonceRepository;
use App\Repository\LitigeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class UpdateLitigeController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(AnnonceRepository $annonceRepository, TokenStorageInterface $tokenStorage, UserRepository $userRepository, LitigeRepository $litigeRepository): Litige
    {
        $request = $this->requestStack->getCurrentRequest();
        /*$idAnnonce = $request->get('annonce');
        $annonce = is_numeric($idAnnonce) ? $annonceRepository->findOneBy(['id' => $idAnnonce]) : $idAnnonce;
        $locataire = $userRepository->findOneBy(['email' => $request->get('locataire')]);

        if ($request->get('ownerBanned')) {
            $annonce->getOwner()->setIsVerified(false);
        }

        if ($request->get('renterBanned')) {
            $locataire->setIsVerified(false);
        }*/
        $litige = $litigeRepository->findOneBy(['id' => $request->get('id')]);

        $litige->setDecision($request->get('decision'));
        $litige->setDecisionExplanation($request->get('explanation'));
        $litige->setStatus(1);
        $litige->setUpdatedAt(new \DateTimeImmutable());

        return $litige;
    }

}
