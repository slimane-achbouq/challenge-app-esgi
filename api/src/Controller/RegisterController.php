<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper\UserHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

#[AsController]
class RegisterController extends AbstractController
{
    public function __invoke(User $user): User
    {
        $role = UserHelper::$ROLES[$user->getRole()];
        if (!$role) {
            throw new MethodNotAllowedException([]);
        }
        $user->setRoles($role);
        return $user;
    }
}
