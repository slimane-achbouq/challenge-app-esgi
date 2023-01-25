<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
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
use ApiPlatform\Metadata\Patch;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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

//#[Get]
#[GetCollection]
#[Patch(
    denormalizationContext: ['groups' => ['user-update:write']]
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


#[Post(
    uriTemplate: '/users/{name}',
    normalizationContext: ['groups' => ['user:read:verification_account_token']],
    denormalizationContext: ['groups' => ['user:write:verification_account_token']],
    name: 'account_verification'
)]

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
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:write', 'user:read', 'user:read:verification_account_token','user-update:write'])]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Groups(['user:read', 'user:read:verification_account_token','user-update:write'])]
    #[ORM\Column]
    private array $roles = [];

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
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Annonce::class)]
    private Collection $annonces;

    #[Groups(['user:read', 'user:read:verification_account_token','user-update:write'])]
    #[ORM\Column(name: 'is_verified', type: Types::BOOLEAN, nullable: true, options: ["default" => false])]
    private ?bool $isVerified = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: ResetPassword::class)]
    private Collection $resetPasswords;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->resetPasswords = new ArrayCollection();
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
}
