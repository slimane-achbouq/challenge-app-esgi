<?php

namespace App\Controller;

use App\Service\JWTService;
use DateTime;
use App\Entity\ResetPassword;
use App\Repository\UserRepository;
use App\Repository\ResetPasswordRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\SendMailService;

class ResetPasswordController extends AbstractController
{
    public function __construct( private SendMailService $sendMailService )
    {
    }

    #[Route('/reset/password', name: 'app_reset_password', methods:['POST'])]
    public function reset(
        Request $request,
        UserRepository $userRepository,
        ResetPasswordRepository $resetPasswordRepository,
        ): Response
    {
        $body = json_decode($request->getContent(), true);
        $user = $userRepository->findOneByEmail($body['email']);
        $token = uniqid();
        if ($user)
        {
            $resetPassword = new ResetPassword();
            $resetPassword->setToken($token);
            $resetPassword->setCreatedAt(new DateTime());
            $resetPassword->setUtilisateur($user);
            $resetPasswordRepository->save($resetPassword,true);

            //send email here
            $this->sendMailService->send(
                'zakaria@gmail.com',
                $user->getEmail(),
                'Reset your password',
                'reset-password',
                compact('user', 'token')
            );
        }


        return new Response('reset password added');
    }

    #[Route('/update/password/{token}', name: 'app_update_password', methods:['POST'])]
    public function update(Request $request,ResetPasswordRepository $resetPasswordRepository, $token, UserPasswordHasherInterface $encoder): Response
    {
        $body = json_decode($request->getContent(), true);
        $resetPassword = $resetPasswordRepository->findOneByToken($token);
        $now = new \DateTime();
        if ($resetPassword && $resetPassword->getCreatedAt()->modify('+ 3 hour') )
        {
            if ($body['newPassword'] === $body['confirmPassword']) {

                $newPassword = $encoder->hashPassword($resetPassword->getUtilisateur() ,$body['newPassword']);
                $resetPassword->getUtilisateur()->setPassword($newPassword);
                $resetPasswordRepository->save($resetPassword,true);

                return new Response('new password updated');
            } else {
                return new Response('there is a wrong password');
            }

        }

    }
}
