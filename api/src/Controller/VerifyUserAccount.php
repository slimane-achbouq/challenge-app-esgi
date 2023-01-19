<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\JWTService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class VerifyUserAccount extends AbstractController
{
    public function __construct(
        private string $jwtSecret,
        private JWTService $jwt)
    {
    }

    public function __invoke(User $user)
    {
        $verificationAccountToken = $user->getVerifyAccountToken();

        if(
            $this->jwt->isValid($verificationAccountToken) &&
            !$this->jwt->isExpired($verificationAccountToken) &&
            $this->jwt->check($verificationAccountToken, $this->jwtSecret) &&
            !$user->isVerified()){
                $user->setIsVerified(true);
        }

        return $user;
    }
}
