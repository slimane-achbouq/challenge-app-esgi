<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\AddressController;
use App\Controller\RegisterController;
use App\Controller\VerifyUserAccount;
use App\DataPersister\UserDataProcess;
use App\Repository\UserRepository;
use App\State\UserPostProcessor;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Delete;



/* TODO
Je m'inscris en tant que : (Particulier | Auto-entrepreneur/Indépendant | Entreprise | Association)
Particulier => Prénom | Nom | Adresse postale | Mobile | E-mail | Mot de passe
Auto-entrepreneur/Indépendant => {Particulier} + Métier + Nom commercial
Entreprise => Nom commercial | Métier | Adresse postale | Mobile | E-mail | Mot de passe
Association => Nom de l'association | adresse postale | mobile | email | mot de pass
*/

#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
#[Post(
    uriTemplate: '/users/{id}/account-verification',
    controller: VerifyUserAccount::class,
    openapiContext: [
        'summary' => 'Verify user account',
        'description' => 'Verify user account via token received by email.',
        'requestBody' => [
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'verifyAccountToken' => ['type' => 'string'],
                        ]
                    ],
                    'example' => [
                        'verifyAccountToken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoyNywiaWF0IjoxNjc0MDgxNjU5LCJleHAiOjE2NzQwOTI0NTl9.kaC6vYvrsQwSiH73M7SW-hkm-OYbo1lZYkO10Tj8TuE',
                    ]
                ]
            ]
        ]
    ],
    normalizationContext: ['groups' => ['user:read:verification_account_token']],
    denormalizationContext: ['groups' => ['user:write:verification_account_token']],
    name: 'account_verification'
)]
#[Get]
#[GetCollection]
#[Patch(denormalizationContext: ['groups' => ['user-update:write']])]
#[Post(
    uriTemplate: '/users',
    controller: RegisterController::class,
    normalizationContext: ['groups' => 'users_registration'],
// TODO
//    openapiContext: [
//        'summary' => 'User Registration',
//        'description' => 'User Registration',
//        'requestBody' => [
//            'content' => [
//                'application/merge-patch+json' => [
//                    'schema' => [
//                        'type' => 'object',
//                        'properties' => [
//                            'email' => ['type' => 'string'],
//                        ]
//                    ],
//                    'example' => [
//                        'email' => 'slach@gmail.com',
//                    ]
//                ]
//            ]
//        ]
//    ],
    name: 'users_registration',
    processor: UserPostProcessor::class,
)]
#[Delete]
#[Get(
    uriTemplate: '/address/{address}',
    controller: AddressController::class,
    openapiContext: [
        'parameters' => [[
            'name' => 'address',
            'in' => 'path',
            'description' => 'address to search',
            'type' => 'string',
            'required' => true,
            'example' => '35 sir waji'
        ]]
    ],
//    openapiContext: [
//        'summary' => 'Address search',
//        'description' => 'Search address via api',
//        'queryParameter' => [
//            'content' => [
//                'application/json' => [
//                    'schema' => [
//                        'type' => 'object',
//                        'properties' => [
//                            'address' => ['type' => 'string'],
//                        ]
//                    ],
//                    'example' => [
//                        'address' => '35 sir waji',
//                    ]
//                ]
//            ]
//        ]
//    ],
    read: false,
    write: false,
    name: 'address_search'
)]


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]

#[ApiFilter(SearchFilter::class, properties: ['email' => 'exact','lastName'=>'exact'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read','user:read:verification_account_token'])]
    private ?int $id = null;

    #[Groups(['user:write', 'user:read', 'user:read:verification_account_token', 'user-update:write', 'annonce:read', 'demande:read', 'demande_history:read', 'litige:read'])]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Groups(['user:read', 'user:read:verification_account_token', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column]
    private array $roles = [];

    #[Groups(['user:write', 'annonce:read', 'demande:read', 'litige:read'])]
    private string $role;

    #[Groups(['user:write:verification_account_token'])]
    private ?string $verifyAccountToken = null;

    /**
     * @var string The hashed password
     */
    #[Assert\Length(
        min: 5,
        minMessage: 'Your password must be at least {{ limit }} characters long',
    )]
    #[Groups(['user:write'])]
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Annonce::class,cascade: ['remove'], orphanRemoval: true)]
    private Collection $annonces;

    #[Groups(['user:read', 'user:read:verification_account_token', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(name: 'is_verified', type: Types::BOOLEAN, nullable: true, options: ["default" => false])]
    private ?bool $isVerified = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: ResetPassword::class)]
    private Collection $resetPasswords;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $associationName = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profession = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commercialName = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[Groups(['user:write', 'user:read', 'user-update:write', 'annonce:read', 'demande:read', 'litige:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\OneToMany(mappedBy: 'locataire', targetEntity: Demande::class,cascade: ['remove'], orphanRemoval: true)]
    #[Groups(['demande_history:read'])]
    private Collection $demandes;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: DemandeHistory::class,cascade: ['remove'], orphanRemoval: true)]
    #[Groups(['demande_history:read', 'demande:read'])]
    private Collection $demandeHistories;

    #[ORM\OneToMany(mappedBy: 'locataire', targetEntity: Paiement::class,cascade: ['remove'], orphanRemoval: true)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'locataire', targetEntity: Litige::class,cascade: ['remove'], orphanRemoval: true)]
    private Collection $litiges;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->resetPasswords = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->demandeHistories = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->litiges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->setOwner($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getOwner() === $this) {
                $annonce->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ResetPassword>
     */
    public function getResetPasswords(): Collection
    {
        return $this->resetPasswords;
    }

    public function addResetPassword(ResetPassword $resetPassword): self
    {
        if (!$this->resetPasswords->contains($resetPassword)) {
            $this->resetPasswords->add($resetPassword);
            $resetPassword->setUtilisateur($this);
        }

        return $this;
    }

    public function removeResetPassword(ResetPassword $resetPassword): self
    {
        if ($this->resetPasswords->removeElement($resetPassword)) {
            // set the owning side to null (unless already changed)
            if ($resetPassword->getUtilisateur() === $this) {
                $resetPassword->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVerifyAccountToken(): ?string
    {
        return $this->verifyAccountToken;
    }

    /**
     * @param string|null $verifyAccountToken
     */
    public function setVerifyAccountToken(?string $verifyAccountToken): void
    {
        $this->verifyAccountToken = $verifyAccountToken;
    }

    public function getAssociationName(): ?string
    {
        return $this->associationName;
    }

    public function setAssociationName(?string $associationName): self
    {
        $this->associationName = $associationName;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }

    public function setCommercialName(?string $commercialName): self
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
        
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setLocataire($this);
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
        
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getLocataire() === $this) {
                $demande->setLocataire(null);
            }
        }
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
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
            $demandeHistory->setOwner($this);
        }
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function removeDemandeHistory(DemandeHistory $demandeHistory): self
    {
        if ($this->demandeHistories->removeElement($demandeHistory)) {
            // set the owning side to null (unless already changed)
            if ($demandeHistory->getOwner() === $this) {
                $demandeHistory->setOwner(null);
            }
        }

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
            $paiement->setLocataire($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getLocataire() === $this) {
                $paiement->setLocataire(null);
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
            $litige->setLocataire($this);
        }

        return $this;
    }

    public function removeLitige(Litige $litige): self
    {
        if ($this->litiges->removeElement($litige)) {
            // set the owning side to null (unless already changed)
            if ($litige->getLocataire() === $this) {
                $litige->setLocataire(null);
            }
        }

        return $this;
    }
}
