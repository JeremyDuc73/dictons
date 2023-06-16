<?php

namespace App\Controller;

use App\Repository\DictonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale}/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', requirements: ['_locale'=>'en|fr|es'])]
    public function index(DictonRepository $dictonRepository, PaginatorInterface $paginator, Request $request, TranslatorInterface $translator): Response
    {
        $dictons = $dictonRepository->findAll();

        $pagination = $paginator->paginate(
            $dictons,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('home/index.html.twig',[
            "pagination"=>$pagination
        ]);
    }
}
