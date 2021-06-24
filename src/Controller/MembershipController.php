<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Form\MembershipType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MembershipController extends AbstractController
{
    /**
     * @Route("/new_membership", name="new_membership")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $membership = new Membership();
        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pdfFile */
            $pdfFile = $form->get('pdf')->getData();
            if ($pdfFile !== null) {
                $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pdfFile->guessExtension();

                try {
                    $directory = $this->getParameter('pdf_directory');
                    if (is_string($directory)) {
                        $pdfFile->move(
                            $directory,
                            $newFilename
                        );
                    } else {
                        throw new HttpException(
                            500,
                            "Paramètres pdf_directory invalide, contacter les administrateurs du site"
                        );
                    }
                } catch (FileException $e) {
                    return $this->render('membership/new.html.twig', [
                        'form' => $form->createView(),
                        'error' => "Une erreur a eu lieu lors de la création du fichier, veuillez réessayer."
                    ]);
                } catch (ServiceNotFoundException $e) {
                    throw $e;
                }
                $membership->setPdfFilename($newFilename);
            }
            $entityManager->persist($membership);
            $entityManager->flush();

            $this->addFlash('success', "Le bulletin d'adhésion a bien été mis à jour.");

            return $this->redirectToRoute('home');
        }
        return $this->render('membership/new.html.twig', [
            'form' => $form->createView(),
            "error" => ""
        ]);
    }
}
