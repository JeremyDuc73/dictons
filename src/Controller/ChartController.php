<?php

namespace App\Controller;

use App\Repository\DictonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder, DictonRepository $dictonRepository): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $oldestDate = $dictonRepository->findBy([], ['createdAt'=>'ASC'])[0]->getCreatedAt()->format('Y');
        $curDate = new \DateTime();
        $curDate = $curDate->format('Y');
        for ($i = $oldestDate; $i <= $curDate; $i++) {
            $years[] = $i;
        }

        foreach ($years as $year){
            $dicton = $dictonRepository->countByYear($year);
            $dictons[] = $dicton;
        }

        $chart->setData([
            'labels' => $years,
            'datasets' => [
                [
                    'label' => "Nombre de dictons en fonction de l'année",
                    'backgroundColor' => 'rgb(255, 99, 132, .4)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $dictons,
                    'tension' => 0,
                ]
            ],
        ]);

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 500,
                ],
            ],
        ]);

        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
