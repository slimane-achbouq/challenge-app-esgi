<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RegisterController extends AbstractController
{
    public function __invoke(User $user): User
    {
        return $user;
    }
}
