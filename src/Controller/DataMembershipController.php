<?php

namespace App\Controller;

use App\DataForm\DataMembership;
use App\Form\DataMembershipType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class DataMembershipController extends AbstractController
{
    /**
     * @Route("/new_membership", name="new_membership")
     */
    public function new(
        Request $request
    ): Response {
        $membership = new DataMembership();
        $form = $this->createForm(DataMembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pdfFile */
            $pdfFile = $form->get('membershipFile')->getData();
            if ($pdfFile !== null) {
                try {
                    $directory = $this->getParameter('pdf_directory');
                    if (is_string($directory)) {
                        $pdfFile->move(
                            $directory,
                            'membership.pdf'
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
                $membership->setMembershipFile($pdfFile);
            }

            $this->addFlash('success', "Le bulletin d'adhésion a bien été mis à jour.");

            return $this->redirectToRoute('home');
        }
        return $this->render('membership/new.html.twig', [
            'form' => $form->createView(),
            "error" => ""
        ]);
    }
}
