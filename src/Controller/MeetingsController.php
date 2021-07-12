<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingsController extends AbstractController
{
    /**
     * @Route("/meetings", name="meetings")
     */
    public function meetings(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(
            ['type' => 'rencontres'],
            ['date' => 'DESC']
        );
        return $this->render('meetings/meetings.html.twig', [
            'articles' => $articles
        ]);
    }
}
