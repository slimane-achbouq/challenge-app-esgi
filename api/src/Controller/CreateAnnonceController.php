<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class CreateAnnonceController extends AbstractController
{
    public function __invoke(Request $request, TokenStorageInterface $tokenStorage): Annonce
    {
        $request = $this->requestStack->getCurrentRequest();
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('Image file is required');
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

        return $annonce;
    }
}
