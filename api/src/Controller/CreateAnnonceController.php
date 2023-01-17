<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class CreateAnnonceController extends AbstractController
{
    private $slugger;
    private $em;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $entityManager) {
        $this->slugger = $slugger;
        $this->em = $entityManager;
    }
    public function __invoke()
    {
        $annonce = new Annonce();
        $annonce->setTitle($_POST['title']);
        $annonce->setDescription($_POST['description']);
        $annonce->setCreatedAt(new \DateTime());

        $file = $_POST["imageFile"];

        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('images_annonces_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                return new \Exception("Upload Annonce image error : " . $e);
            }

            $annonce->setImage($newFilename);
        }

        $this->em->persist($annonce);
        $this->em->flush();
    }
}
