<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivEllesController extends AbstractController
{
    /**
     * @Route("/festivelles", name="festivelles")
     */
    public function index(ArticleRepository $articleRepository, CalendarRepository $calendarRepository): Response
    {
        $articles = $articleRepository->findBy(
            ['type' => 'festivelles'],
            ['date' => 'DESC']
        );
        $events = $calendarRepository->findBy(
            ['type' => 'festivelles'],
            ['date' => 'ASC']
        );
        return $this->render('festiv_elles/index.html.twig', [
            'articles' => $articles,
            'events' => $events
        ]);
    }
}
