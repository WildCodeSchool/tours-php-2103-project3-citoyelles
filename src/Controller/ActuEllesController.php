<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuEllesController extends AbstractController
{
    /**
     * @Route("/actu'elles", name="actu_elles")
     */
    public function index(): Response
    {
        return $this->render('actu_elles/index.html.twig');
    }
}
