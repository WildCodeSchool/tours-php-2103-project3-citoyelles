<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingsController extends AbstractController
{
    /**
     * @Route("/meetings", name="meetings")
     */
    public function meetings(ArticleRepository $articleRepository, CalendarRepository $calendarRepository): Response
    {
        $articles = $articleRepository->findBy(
            ['type' => 'rencontres'],
            ['date' => 'DESC']
        );
        $events = $calendarRepository->findBy(
            ['type' => 'rencontres'],
            ['date' => 'ASC']
        );
        return $this->render('meetings/meetings.html.twig', [
            'articles' => $articles,
            'events' => $events
        ]);
    }
}
