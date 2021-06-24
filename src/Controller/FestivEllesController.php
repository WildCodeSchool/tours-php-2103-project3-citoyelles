<?php

namespace App\Controller;

use App\Entity\Member;
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
        $members = $this->getDoctrine()
            ->getRepository(Member::class)
            ->findBy([], ["title" => "ASC"]);
        $membersOrdered = [];
        foreach ($members as $member) {
            $membersOrdered[$member->getTitle()][] = $member;
        }
        return $this->render('festiv_elles/index.html.twig', ["membersOrdered" => $membersOrdered]);
    }
}
