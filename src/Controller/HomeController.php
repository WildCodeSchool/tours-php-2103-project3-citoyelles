<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ): Response {
        $users = $userRepository->findAll();
        if ($users === []) {
            User::createFirstUser($passwordEncoder, $entityManager);
        }
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/about/", name="about")
     */
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }
}
