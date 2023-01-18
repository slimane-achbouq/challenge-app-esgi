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
//#[Get]
#[GetCollection]
//#[Delete]
#[Patch(
    denormalizationContext: ['groups' => ['patch_annonce:write']]
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
                            'proprietaire' => [
                                'type' => 'int'
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
#[ApiFilter(SearchFilter::class, properties: ['title' => 'ipartial', 'description' => 'ipartial'])]
#[ApiFilter(RangeFilter::class, properties: ['price'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(BooleanFilter::class, properties: ['isPerHour'])]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read', 'patch_annonce:write'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['annonce:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[Vich\UploadableField(mapping: "annonce_imageFile", fileNameProperty: "image")]
    #[Assert\NotNull(groups: ['annonce_imageFile_create'])]
    #[Groups(['annonce:write'])]
    private ?File $file = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[Groups(['annonce:write', 'annonce:read'])]
    private ?User $proprietaire = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read', 'patch_annonce:write'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['edit_annonce:write', 'annonce:read', 'patch_annonce:write'])]
    private ?bool $isAvailable = null;

    #[ORM\Column]
    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read', 'patch_annonce:write'])]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['annonce:write', 'edit_annonce:write', 'annonce:read', 'patch_annonce:write'])]
    private ?bool $isPerHour = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

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
        $this->status = "0";
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

    public function getProprietaire(): ?User
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?User $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
