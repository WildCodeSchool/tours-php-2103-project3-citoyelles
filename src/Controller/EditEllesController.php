<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditEllesController extends AbstractController
{
    /**
     * @Route("/editelles", name="editelles")
     */
    public function index(): Response
    {
        return $this->render('edit_elles/index.html.twig');
    }
}
