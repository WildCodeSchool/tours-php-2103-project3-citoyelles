<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivEllesController extends AbstractController
{
    /**
     * @Route("/festivelles", name="festiv_elles")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(
            ['type' => 'festivelles'],
            ['date' => 'DESC'],
            4
        );
        // $articles = $articleRepository->findAll();
        return $this->render('festiv_elles/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
