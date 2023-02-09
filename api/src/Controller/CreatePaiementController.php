<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Paiement;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeRepository;
use App\Repository\PaiementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreatePaiementController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(
        AnnonceRepository     $annonceRepository,
        TokenStorageInterface $tokenStorage,
        UserRepository        $userRepository,
        PaiementRepository    $paiementRepository,
        DemandeRepository     $demandeRepository)
    {
        $request = $this->requestStack->getCurrentRequest();
        $idAnnonce = $request->get('annonce');
        $idDemande = $request->get('idDemande');
        $annonce = is_numeric($idAnnonce) ? $annonceRepository->findOneBy(['id' => $idAnnonce]) : $idAnnonce;
        $locataire = $userRepository->findOneBy(['email' => $request->get('locataire')]);
        $existingPaiement = $paiementRepository->findOneBy(['demande' => $idDemande]);
        $demande = $demandeRepository->findOneBy(['id' => $idDemande]);

        if (!$existingPaiement) {
            $paiement = new Paiement();
            $paiement->setAnnonce($annonce);
            $paiement->setCreatedAt(new \DateTimeImmutable());
            $paiement->setMontant($request->get('montant'));
            $paiement->setLocataire($locataire);
            $paiement->setDemande($demande);
        } else {
            $paiement = $existingPaiement;
        }

        return $paiement;
    }

}
