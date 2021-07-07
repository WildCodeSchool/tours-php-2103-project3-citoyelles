<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/new", name="new_article", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile !== null) {
                $imageFilename = $fileUploader->upload($imageFile);
                if ($imageFilename === "") {
                    $this->addFlash("error", "Impossible de récupérer le fichier, veuillez contacter l'administrateur");
                    return $this->redirectToRoute('home'); // NON DÉFINITIF
                }
                $article->setImageFilename($imageFilename);
            }
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', "L'article a bien été créé.");

            switch ($article->getType()) {
                case 'festivelles':
                    return $this->redirectToRoute('festivelles');
                case 'citoyelles':
                    return $this->redirectToRoute('actuelles');
                case 'portrelles':
                    return $this->redirectToRoute('actuelles');
            }
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
            "error" => ""
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_article", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(
        EntityManagerInterface $entityManager,
        Request $request,
        Article $article,
        FileUploader $fileUploader
    ): Response {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile !== null) {
                $imageFilename = $fileUploader->upload($imageFile);
                if ($imageFilename === "") {
                    $this->addFlash("error", "Impossible de récupérer le fichier, veuillez contacter l'administrateur");
                    return $this->redirectToRoute('home'); // NON DÉFINITIF
                }
                $fileUploader->delete($article->getImageFilename());
                $article->setImageFilename($imageFilename);
            }
            $entityManager->flush();

            $this->addFlash('success', "L'article a bien été modifié.");

            switch ($article->getType()) {
                case 'festivelles':
                    return $this->redirectToRoute('festivelles');
                case 'citoyelles':
                    return $this->redirectToRoute('actuelles');
                case 'portrelles':
                    return $this->redirectToRoute('actuelles');
            }
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_article", requirements={"id": "\d+"}, methods={"POST"})
     */
    public function delete(
        Request $request,
        Article $article,
        FileUploader $fileUploader
    ): Response {
        $articleType = $article->getType();
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $fileUploader->delete($article->getImageFilename());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', "L'article a bien été supprimé.");

            switch ($articleType) {
                case 'festivelles':
                    return $this->redirectToRoute('festivelles');
                case 'citoyelles':
                    return $this->redirectToRoute('actuelles');
                case 'portrelles':
                    return $this->redirectToRoute('actuelles');
            }
        }
        throw $this->createAccessDeniedException('Erreur 403 : Vous êtes en train de faire quelque chose d\'interdit.');
    }
}