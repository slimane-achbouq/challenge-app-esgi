<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class CreateAnnonceController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(TokenStorageInterface $tokenStorage): Annonce
    {
        $request = $this->requestStack->getCurrentRequest();
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('Image file is required');
        }

        if ($request->getContent()) {
            $request->request->add(json_decode($request->getContent(), true));
        }

        $annonce = new Annonce();
        $annonce->setTitle($request->get('title'));
        $annonce->setDescription($request->get('description'));
        $annonce->setFile($uploadedFile);
        $annonce->setImage($uploadedFile->getClientOriginalName());
        $annonce->setOwner($tokenStorage->getToken()->getUser());
        $annonce->setPrice($request->get('price'));
        $annonce->setIsPerHour($request->get('isPerHour'));
        $annonce->setIsAvailable($request->get('isAvailable'));
        $annonce->setCategory($request->get('category'));

        return $annonce;
    }
}
