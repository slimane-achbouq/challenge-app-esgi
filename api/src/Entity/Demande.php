<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\CreateDemandeController;
use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['demande:read']],
    denormalizationContext: ['groups' => ['demande:write']],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 5,
    paginationMaximumItemsPerPage: 5
)]
#[ORM\Entity(repositoryClass: DemandeRepository::class)]
#[ORM\Table(name: '`demande`')]
#[GetCollection]
#[Get]
#[Patch(
    denormalizationContext: ['groups' => ['patch_status:write']]
)]
#[Put(
    denormalizationContext: ['groups' => ['edit_demande:write']]
)]
#[Post(
    uriTemplate: "/demandes",
    controller: CreateDemandeController::class,
    deserialize: false,
    name: 'Create Demande with Annonce fk'
)]
//#[ApiFilter(SearchFilter::class, properties: ['annonce.title' => 'ipartial', 'annonce.description' => 'ipartial', 'user.email' => 'ipartial'])]
//#[ApiFilter(DateFilter::class, properties: ['createdAt', 'dateStart', 'dateEnd'])]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['demande:read'])]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['patch_status:write', 'demande:read', 'edit_demande:write', 'demande_history:read'])]
    private ?int $status = null;

    #[ORM\Column]
    #[Groups(['demande:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['demande:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['demande:write', 'edit_demande:write', 'demande:read'])]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['demande:write', 'edit_demande:write', 'demande:read'])]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\ManyToOne(inversedBy: 'demande')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['demande:read', 'annonce:read'])]
    private ?Annonce $annonce = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    #[Groups(['demande:read', 'user:read'])]
    private ?User $locataire = null;

    #[ORM\OneToMany(mappedBy: 'demand', targetEntity: DemandeHistory::class)]
    #[Groups(['demande:read'])]
    private Collection $demandeHistories;

    #[ORM\Column(nullable: true)]
    #[Groups(['demande:read'])]
    private ?bool $isPaid = null;

    public function __construct()
    {
        $this->demandeHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
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

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->status = 0;
        $this->isPaid = false;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, DemandeHistory>
     */
    public function getDemandeHistories(): Collection
    {
        return $this->demandeHistories;
    }

    public function addDemandeHistory(DemandeHistory $demandeHistory): self
    {
        if (!$this->demandeHistories->contains($demandeHistory)) {
            $this->demandeHistories->add($demandeHistory);
            $demandeHistory->setDemand($this);
        }

        return $this;
    }

    public function removeDemandeHistory(DemandeHistory $demandeHistory): self
    {
        if ($this->demandeHistories->removeElement($demandeHistory)) {
            // set the owning side to null (unless already changed)
            if ($demandeHistory->getDemand() === $this) {
                $demandeHistory->setDemand(null);
            }
        }

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }
}
