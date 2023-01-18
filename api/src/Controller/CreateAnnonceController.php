<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsController]
class CreateAnnonceController extends AbstractController
{
    public function __invoke(Request $request, UserRepository $userRepository): Annonce
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $idUser = $request->get('proprietaire');

        if (is_numeric($idUser)) {
            $user = $userRepository->findOneBy(["id" => $idUser]);
        }
        else {
            $user = $idUser;
        }

        $annonce = new Annonce();
        $annonce->setTitle($request->get('title'));
        $annonce->setDescription($request->get('description'));
        $annonce->setFile($uploadedFile);
        $annonce->setImage($uploadedFile->getClientOriginalName());
        $annonce->setProprietaire($user);
        $annonce->setCreatedAt(new \DateTime());
        $annonce->setUpdatedAt(new \DateTimeImmutable());

        return $annonce;
    }
}
