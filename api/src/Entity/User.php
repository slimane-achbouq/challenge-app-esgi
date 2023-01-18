<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Controller\RegisterController;
use App\DataPersister\UserDataProcess;
use App\Repository\UserRepository;
use App\State\UserPostProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;


/* TODO
Je m'inscris en tant que : (Particulier | Auto-entrepreneur/Indépendant | Entreprise | Association)
Particulier => Prénom | Nom | Adresse postale | Mobile | E-mail | Mot de passe
Auto-entrepreneur/Indépendant => {Particulier} + Métier + Nom commercial
Entreprise => Nom commercial | Métier | Adresse postale | Mobile | E-mail | Mot de passe
Association => Nom de l'association | adresse postale | mobile | email | mot de pass
*/
#[ApiResource(
    denormalizationContext: ['groups' => ['user:write']],
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
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:write'])]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

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
        return (string) $this->email;
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
}
