<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsController]
class CreateAnnonceController extends AbstractController
{
    public function __invoke(Request $request): Annonce
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $annonce = new Annonce();
        $annonce->setTitle($request->get('title'));
        $annonce->setDescription($request->get('description'));
        $annonce->setFile($uploadedFile);
        $annonce->setImage($uploadedFile->getClientOriginalName());
        $annonce->setCreatedAt(new \DateTime());
        $annonce->setUpdatedAt(new \DateTimeImmutable());

        return $annonce;
    }
}
