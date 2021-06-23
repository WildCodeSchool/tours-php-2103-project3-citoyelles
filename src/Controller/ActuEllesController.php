<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuEllesController extends AbstractController
{
    /**
     * @Route("/actuelles", name="actu_elles")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(
            ['type' => 'citoyelles'],
            ['date' => 'DESC']
        );

        $portraits = $articleRepository->findBy(
            ['type' => 'portrelles']
        );

        return $this->render('actu_elles/index.html.twig', [
            'articles' => $articles,
            'portraits' => $portraits
        ]);
    }


}
