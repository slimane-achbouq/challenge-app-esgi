<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use App\Entity\User;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

final class UserAccountVerificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private string $jwtSecret,
        private SendMailService $sendMailService,
        private JWTService $jwt,
        private LoggerInterface $logger)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logger->info('HELLOOOOOOOOO');
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $this->sendVerificationAccountEmail($entity);
        $this->logger->info('Email Sent !!!!!');
    }

    private function sendVerificationAccountEmail(User $user)
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $payload = [
            'user_id' => $user->getId()
        ];

        $token = $this->jwt->generate($header, $payload, $this->jwtSecret);

        // On envoie un mail
        $this->sendMailService->send(
            'slimane321@gmail.com',
            $user->getEmail(),
            'Activation de votre compte sur le site e-commerce',
            'register',
            compact('user', 'token')
        );
    }
}
