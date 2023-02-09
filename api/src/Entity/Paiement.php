<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\CreatePaiementController;
use App\Repository\PaiementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['paiement:read']],
    denormalizationContext: ['groups' => ['paiement:write']],
)]
#[ORM\Table(name: '`paiement`')]
#[Get]
#[Post(
    uriTemplate: "/paiements",
    controller: CreatePaiementController::class,
    deserialize: false,
    name: 'Create Paiement'
)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['paiement:write', 'paiement:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['paiement:write', 'paiement:read'])]
    private ?float $montant = null;

    #[Groups(['paiement:write', 'paiement:read', 'demande:read', 'annonce:read', 'user:read'])]
    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Annonce $annonce = null;

    #[Groups(['paiement:write', 'paiement:read', 'demande:read', 'annonce:read'])]
    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?User $locataire = null;

    #[ORM\OneToOne(inversedBy: 'paiement', cascade: ['persist', 'remove'])]
    private ?Demande $demande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getLocataire(): ?User
    {
        return $this->locataire;
    }

    public function setLocataire(?User $locataire): self
    {
        $this->locataire = $locataire;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }
}
