<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\AvailableAnnonceController;
use App\Controller\CreateAnnonceController;
use App\Repository\AnnonceRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['annonce:read']],
    denormalizationContext: ['groups' => ['annonce:write']],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 5,
    paginationMaximumItemsPerPage: 5
)]
#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ORM\Table(name: '`annonce`')]
#[Get]
#[GetCollection]
#[Delete]
#[Patch(
    denormalizationContext: ['groups' => ['patch_status_annonce:write']],
    security: 'is_granted("ROLE_ADMIN")'
)]
#[Put(
    denormalizationContext: ['groups' => ['edit_annonce:write']]
)]
#[Post(
    uriTemplate: '/annonces',
    controller: CreateAnnonceController::class,
    openapiContext: [
        'requestBody' => [
            'content' => [
                'multipart/form-data' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'file' => [
                                'type' => 'string',
                                'format' => 'binary'
                            ],
                            'title' => [
                                'type' => 'string'
                            ],
                            'description' => [
                                'type' => 'text'
                            ],
                            'price' => [
                                'type' => 'float'
                            ],
                            'isPerHour' => [
                                'type' => 'boolean'
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ],
    validationContext: ['groups' => ['Default', 'annonce_imageFile_create']],
    deserialize: false,
    name: 'Create Annonce with image upload'
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'ipartial', 'description' => 'ipartial','category' => 'ipartial'])]
#[ApiFilter(RangeFilter::class, properties: ['price'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(BooleanFilter::class, properties: ['isPerHour'])]
#[ApiFilter(NumericFilter::class, properties: ['status'])]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonce:read', 'demande:read', 'litige:read','user:read'])]
    private ?int $id = null;

    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read','patch_status_annonce:write', 'demande:read', 'litige:read','user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['annonce:read', 'demande:read', 'litige:read','user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['annonce:read', 'demande:read', 'litige:read','user:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[Vich\UploadableField(mapping: "annonce_imageFile", fileNameProperty: "image")]
    #[Assert\NotNull(groups: ['annonce_imageFile_create'])]
    #[Groups(['annonce:write'])]
    private ?File $file = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[Groups(['annonce:read', 'user:read', 'demande:read', 'litige:read'])]
    private ?User $owner = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read','patch_status_annonce:write', 'demande:read', 'litige:read','user:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['edit_annonce:write', 'annonce:read','patch_status_annonce:write', 'demande:read', 'litige:read','user:read'])]
    private ?bool $isAvailable = null;

    #[ORM\Column]
    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read','patch_status_annonce:write', 'demande:read', 'litige:read','user:read'])]
    private ?float $price = null;

    #[ORM\Column(nullable: true, options: ["default" => false])]
    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read','patch_status_annonce:write', 'demande:read', 'litige:read','user:read'])]
    private ?bool $isPerHour = null;

    #[ORM\Column]
    #[Groups(['patch_status_annonce:write', 'annonce:read', 'demande:read', 'litige:read','user:read'])]
    private ?int $status = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Demande::class)]
    private ?Collection $demande = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Litige::class)]
    private Collection $litiges;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['annonce:write','user:read','patch_status_annonce:write', 'annonce:read', 'demande:read', 'litige:read','edit_annonce:write'])]
    private ?string $category = null;

    public function __construct()
    {
        $this->demande = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->litiges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): ?\DateTimeImmutable
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isAvailable = true;
        $this->status = 0;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    /*public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }*/

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(?bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isIsPerHour(): ?bool
    {
        return $this->isPerHour;
    }

    public function setIsPerHour(?bool $isPerHour): self
    {
        $this->isPerHour = $isPerHour;

        return $this;
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

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setAnnonce($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getAnnonce() === $this) {
                $paiement->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Litige>
     */
    public function getLitiges(): Collection
    {
        return $this->litiges;
    }

    public function addLitige(Litige $litige): self
    {
        if (!$this->litiges->contains($litige)) {
            $this->litiges->add($litige);
            $litige->setAnnonce($this);
        }

        return $this;
    }

    public function removeLitige(Litige $litige): self
    {
        if ($this->litiges->removeElement($litige)) {
            // set the owning side to null (unless already changed)
            if ($litige->getAnnonce() === $this) {
                $litige->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getDemande(): Collection
    {
        return $this->demande;
    }

    public function addDemande(Annonce $demande): self
    {
        if (!$this->demande->contains($demande)) {
            $this->demande->add($demande);
            $demande->setAnnonce($this);
        }

        return $this;
    }

    public function removeDemande(Annonce $demande): self
    {
        if ($this->demande->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getAnnonce() === $this) {
                $demande->setAnnonce(null);
            }
        }

        return $this;
    }
}
