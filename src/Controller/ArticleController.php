<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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

class ArticleController extends AbstractController
{
    /**
     * @Route("/new_article", name="new_article")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $articleRequest = $request->request->all();

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile !== null) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $directory = $this->getParameter('images_directory');
                    if (is_string($directory)) {
                        $imageFile->move(
                            $directory,
                            $newFilename
                        );
                    } else {
                        throw new HttpException(
                            500,
                            "Paramètres images_directory invalide, contacter les administrateurs du site"
                        );
                    }
                } catch (FileException $e) {
                    return $this->render('article/new.html.twig', [
                        'form' => $form->createView(),
                        'error' => "Une erreur a eu lieu lors de la création du fichier, veuillez réessayer."
                    ]);
                } catch (ServiceNotFoundException $e) {
                    throw $e;
                }
                $article->setImageFilename($newFilename);
            }
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', "L'article a bien été créé.");

            return $this->redirectToRoute($articleRequest['article']['type']);
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
            "error" => ""
        ]);
    }
}
