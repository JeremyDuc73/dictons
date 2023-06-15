<?php

namespace App\Controller;

use App\Entity\Dicton;
use App\Repository\AuthorRepository;
use App\Repository\DictonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/api')]
class DictonController extends AbstractController
{
    #[Route('/dicton', name: 'app_dicton', methods: ['GET'])]
    public function index(DictonRepository $dictonRepository): Response
    {
        return $this->json($dictonRepository->findAll(), 200, [], ['groups'=>'dicton:read']);
    }

    #[Route('/dicton/show/{id}', name: 'app_dicton_show', methods: ['GET'])]
    public function show(DictonRepository $dictonRepository, Dicton $dicton){

        return $this->json($dictonRepository->findOneBy(['id'=>$dicton->getId()]), 200, [], ['groups'=>'dicton:read-one']);
    }

    #[Route('/dicton/create', name: 'app_dicton_create', methods: ['POST'])]
    public function create(SerializerInterface $serializer, Request $request, DictonRepository $dictonRepository, AuthorRepository $authorRepository): Response
    {
        $json = $request->getContent();
        $dicton = $serializer->deserialize($json, Dicton::class, 'json');
        $author = $authorRepository->findOneBy(['name'=> $dicton->getAuthor()->getName()]);
        if (!$author){
            $authorRepository->save($dicton->getAuthor());
        }else{
            $dicton->setAuthor($author);
        }
        $dicton->setCreatedAt(new \DateTimeImmutable());
        $dictonRepository->save($dicton, true);
        return $this->json($dicton, 200, [], ['groups'=>'dicton:read-one']);
    }
}
