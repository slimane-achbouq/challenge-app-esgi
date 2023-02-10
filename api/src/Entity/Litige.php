<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\CreateLitigeController;
use App\Controller\UpdateLitigeController;
use App\Repository\LitigeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: LitigeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['litige:read']],
    denormalizationContext: ['groups' => ['litige:write']],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 5,
    paginationMaximumItemsPerPage: 5
)]
#[Post(
    uriTemplate: "/litiges",
    controller: CreateLitigeController::class,
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
                            'raison' => [
                                'type' => 'string'
                            ],
                            'autreRaison' => [
                                'type' => 'text'
                            ],
                            'description' => [
                                'type' => 'text'
                            ],
                            'status' => [
                                'type' => 'integer'
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ],
    validationContext: ['groups' => ['Default', 'litige_imageFile_create']],
    deserialize: false,
    name: 'Create Litige',
)]
#[Get]
#[GetCollection]
#[ORM\Table(name: '`litige`')]
#[ORM\HasLifecycleCallbacks]
#[Patch(
    denormalizationContext: ['groups' => ['patch_status_litige:write']]
)]
#[Put(
    denormalizationContext: ['groups' => ['edit_litige:write']],
)]
class Litige
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['litige:read'])]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: "litige_imageFile", fileNameProperty: "image")]
    #[Groups(['litige:write', 'litige_imageFile_create'])]
    private ?File $file = null;

    #[Groups(['litige:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups(['litige:read'])]
    private ?string $raison = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['litige:read'])]
    private ?string $autreRaison = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['litige:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['litige:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'litiges')]
    #[Groups(['litige:read', 'annonce:read', 'user:read', 'demande:read'])]
    private ?Annonce $annonce = null;

    #[ORM\ManyToOne(inversedBy: 'litiges')]
    #[Groups(['litige:read', 'annonce:read', 'user:read', 'demande:read'])]
    private ?User $locataire = null;

    #[ORM\Column]
    #[Groups(['litige:read', 'patch_status:write', 'edit_litige:write'])]
    private ?int $status = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['litige:read', 'annonce:read', 'user:read', 'demande:read', 'edit_litige:write'])]
    private ?string $decision = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['litige:read', 'annonce:read', 'user:read', 'demande:read', 'edit_litige:write'])]
    private ?string $decisionExplanation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(string $raison): self
    {
        $this->raison = $raison;

        return $this;
    }

    public function getAutreRaison(): ?string
    {
        return $this->autreRaison;
    }

    public function setAutreRaison(?string $autreRaison): self
    {
        $this->autreRaison = $autreRaison;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->status = 0;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getDecision(): ?string
    {
        return $this->decision;
    }

    public function setDecision(?string $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    public function getDecisionExplanation(): ?string
    {
        return $this->decisionExplanation;
    }

    public function setDecisionExplanation(?string $decisionExplanation): self
    {
        $this->decisionExplanation = $decisionExplanation;

        return $this;
    }
}
