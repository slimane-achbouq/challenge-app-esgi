<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('slimane321@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsVerified(true);
        $password = $this->passwordHasher->hashPassword(
            $user,
            'slachslach'
        );
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
    }
}
