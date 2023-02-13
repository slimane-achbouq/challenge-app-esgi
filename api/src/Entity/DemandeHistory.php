<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateDemandeController;
use App\Controller\CreateDemandeHistoryController;
use App\Repository\DemandeHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DemandeHistoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['demande_history:read']],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 5,
    paginationMaximumItemsPerPage: 5
)]
#[ORM\Table(name: '`demande_history`')]
#[GetCollection]
#[Get]
#[Post(
    uriTemplate: "/demande_histories",
    controller: CreateDemandeHistoryController::class,
    deserialize: false,
    name: 'Create Demande History when edit Demande dates'
)]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
class DemandeHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['demande_history:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeHistories')]
    #[Groups(['demande_history:read', 'user:read', 'demande:read'])]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'demandeHistories')]
    #[Groups(['demande:read'])]
    private ?Demande $demand = null;

    #[ORM\Column]
    #[Groups(['demande_history:read', 'demande:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['demande_history:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDemand(): ?Demande
    {
        return $this->demand;
    }

    public function setDemand(?Demande $demand): self
    {
        $this->demand = $demand;

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
