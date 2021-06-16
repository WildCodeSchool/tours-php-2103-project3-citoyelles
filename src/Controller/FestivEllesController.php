<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivEllesController extends AbstractController
{
    /**
     * @Route("/festivelles", name="festiv_elles")
     */
    public function index(): Response
    {
        return $this->render('festiv_elles/index.html.twig');
    }
}
