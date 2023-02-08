<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\DemandeHistory;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateDemandeHistoryController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(DemandeRepository $demandeRepository, TokenStorageInterface $tokenStorage, UserRepository $userRepository): DemandeHistory
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $userRepository->findOneBy(['email' => $request->get('owner')]);
        $demande = $demandeRepository->findOneBy(['id' => $request->get('demand')]);

        $demandeHistory = new DemandeHistory();
        $demandeHistory->setOwner($user);
        $demandeHistory->setDemand($demande);
        $demandeHistory->setCreatedAt(new \DateTimeImmutable());
        $demandeHistory->setUpdatedAt(new \DateTimeImmutable());

        return $demandeHistory;
    }

}
