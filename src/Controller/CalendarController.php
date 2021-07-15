<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/", name="index_calendar", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new_calendar", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($calendar);
            $entityManager->flush();

            $this->addFlash('success', "L'évènement a bien été créé.");

            switch ($calendar->getType()) {
                case 'festivelles':
                    return $this->redirectToRoute('festivelles');
                case 'citoyelles':
                    return $this->redirectToRoute('actuelles');
                case 'rencontres':
                    return $this->redirectToRoute('meetings');
            }
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show_calendar", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_calendar", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Calendar $calendar,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', "L'évènement a bien été modifié.");

            switch ($calendar->getType()) {
                case 'festivelles':
                    return $this->redirectToRoute('festivelles');
                case 'citoyelles':
                    return $this->redirectToRoute('actuelles');
                case 'rencontres':
                    return $this->redirectToRoute('meetings');
            }
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_calendar", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function delete(Request $request, Calendar $calendar): Response
    {
        if ($this->isCsrfTokenValid('delete' . $calendar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendar);
            $entityManager->flush();

            $this->addFlash('success', "L'évènement a bien été créé.");

            switch ($calendar->getType()) {
                case 'festivelles':
                    return $this->redirectToRoute('festivelles');
                case 'citoyelles':
                    return $this->redirectToRoute('actuelles');
                case 'rencontres':
                    return $this->redirectToRoute('meetings');
            }
        }

        throw $this->createAccessDeniedException('Erreur 403 : Vous êtes en train de faire quelque chose d\'interdit.');
    }
}
