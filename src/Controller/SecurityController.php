<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormError;
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

        $oldUserName = $user->getUsername();
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if ($oldPassword) {
                if ($user->getPlainPassword()) {
                    if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                        $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                        $user->setPassword($newEncodedPassword);

                        $entityManager->persist($user);
                        $entityManager->flush();

                        $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
                        return $this->redirectToRoute('home');
                    } else {
                        $form->addError(new FormError('Ancien mot de passe incorrect'));
                    }
                } else {
                    $form->addError(new FormError('Nouveau mot de passe non rempli'));
                }
            } elseif ($oldUserName != $user->getUsername()) {
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('notice', 'Votre nom de compte à bien été changé !');
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('notice', 'Aucune modification détecter, veuillez remplir les champs correctement !');
            }
        }
        return $this->render('security/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
