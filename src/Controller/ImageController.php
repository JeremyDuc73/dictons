<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[Route('/api')]
class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image', methods: ['GET'])]
    public function index(ImageRepository $imageRepository) :Response
    {
        return $this->json($imageRepository->findAll(), 200);
    }

    #[Route('/image/upload', name: 'app_image_upload', methods: ['POST'])]
    public function upload(EntityManagerInterface $manager, Request $request, UploaderHelper $helper): Response
    {
        $image = new Image();
        $file = $request->files->get('test');
        $image->setImageFile($file);

        $manager->persist($image);
        $manager->flush();

        $response = [
            "message"=> "c'est upload",
            "idImage"=>$image->getId(),
            "image"=>"https://localhost:8000".$helper->asset($image)
        ];
        return $this->json($response, 200);
    }
}
