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

class ContactController extends AbstractController
{
    public function __construct( private SendMailService $sendMailService )
    {
    }

    #[Route('/contact', name: 'contact', methods:['POST'])]
    public function send(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);
        $mail = $body['email'];
        $firstName = $body['name'];
        $lastName = $body['familyName'];
        $message = $body['message'];

        $this->sendMailService->send(
            'zakaria@gmail.com',
            $mail,
            'Contact',
            'contact',
            compact('message', 'firstName', 'lastName')
        );
        return new Response('Contact Success!');
    }
}
