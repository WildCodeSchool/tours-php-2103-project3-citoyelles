<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank');
    }


    /**
     * @Route("/editUser", name="edit_user")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editUser(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('vous devez etre connecté');
        }
        $userService = new UserService();
        $userService->setNewUsername($user->getUsername());
        $form = $this->createForm(EditUserType::class, $userService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isUsernameValid = $userService->validateNewUsername($user);
            $isPasswordValid = $userService->validateNewPassword($user, $passwordEncoder);

            $errors = $userService->findUserErrors($user, $passwordEncoder, $isPasswordValid);

            if (($isUsernameValid || $isPasswordValid) && !$errors) {
                $entityManager->flush();
                return $this->redirectToRoute('home');
            } elseif ($errors) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error);
                }
            } else {
                $this->addFlash('warning', 'Champs manquant, rien n\'a été modifié');
            }
        }
        return $this->render('security/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
