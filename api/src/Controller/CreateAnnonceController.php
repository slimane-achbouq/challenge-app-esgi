<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class CreateAnnonceController extends AbstractController
{
    public function __invoke(Request $request, TokenStorageInterface $tokenStorage): Annonce
    {
        $uploadedFile = $_FILES['file'];
        if (!$uploadedFile) {
            throw new BadRequestHttpException('Image file is required');
        }

        $file = new UploadedFile($uploadedFile['tmp_name'], $uploadedFile['name']);
        $annonce = new Annonce();
        $annonce->setTitle($_POST['title']);
        $annonce->setDescription($_POST['description']);
        $annonce->setFile($file);
        $annonce->setImage($file->getClientOriginalName());
        $annonce->setOwner($tokenStorage->getToken()->getUser());
        $annonce->setPrice($_POST['price']);
        $annonce->setIsPerHour($_POST['isPerHour']);
        $annonce->setIsAvailable($_POST['isAvailable']);

        return $annonce;
    }
}
