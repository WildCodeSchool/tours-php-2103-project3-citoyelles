<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingsController extends AbstractController
{
    /**
     * @Route("/meetings", name="meetings")
     */
    public function meetings(CalendarRepository $calendarRepository): Response
    {
        $events = $calendarRepository->findBy(
            ['type' => 'rencontres'],
            ['date' => 'ASC']
        );
        return $this->render('meetings/meetings.html.twig', [
            'events' => $events
        ]);
    }
}
