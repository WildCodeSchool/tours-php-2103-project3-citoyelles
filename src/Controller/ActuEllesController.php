<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuEllesController extends AbstractController
{
    /**
     * @Route("/actuelles", name="actuelles")
     */
    public function index(ArticleRepository $articleRepository,CalendarRepository $calendarRepository): Response
    {
        $articles = $articleRepository->findBy(
            ['type' => 'citoyelles'],
            ['date' => 'DESC']
        );

        $calendars = $calendarRepository->findBy(
            ['type' => 'citoyelles']
        );

        $portraits = $articleRepository->findBy(
            ['type' => 'portrelles'],
            ['date' => 'DESC'],
            1
        );

        return $this->render('actu_elles/index.html.twig', [
            'articles' => $articles,
            'calendars' => $calendars,
            'portraits' => $portraits
        ]);
    }
}
