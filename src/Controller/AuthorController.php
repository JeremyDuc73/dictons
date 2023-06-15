<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api')]
class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(AuthorRepository $authorRepository): Response
    {

        return $this->json($authorRepository->findAll(), 200, [], ['groups'=>'author:read']);
    }

    #[Route('/author/show/{id}', name: 'app_author_show', methods: ['GET'])]
    public function show(AuthorRepository $authorRepository, Author $author){

    return $this->json($authorRepository->findOneBy(['id'=>$author->getId()]), 200, [], ['groups'=>'author:read-one']);
    }
}
