<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        $user = is_numeric($idUser) ? $userRepository->findOneBy(["id" => $idUser]) : $idUser;

        $annonce = new Annonce();
        $annonce->setTitle($request->get('title'));
        $annonce->setDescription($request->get('description'));
        $annonce->setFile($uploadedFile);
        $annonce->setImage($uploadedFile->getClientOriginalName());
        $annonce->setProprietaire($user);
        $annonce->setIsAvailable(true);
        $annonce->setPrice($request->get('price'));
        $annonce->setStatus("0");
        $annonce->setIsPerHour($request->get("isPerHour"));
        $annonce->setCreatedAt(new \DateTime());

        return $annonce;
    }
}
