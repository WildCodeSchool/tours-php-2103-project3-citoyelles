<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingsController extends AbstractController
{
    /**
     * @Route("/meetings", name="meeting")
     */
    public function meetings(): Response
    {
        return $this->render('meetings/meetings.html.twig');
    }
}
