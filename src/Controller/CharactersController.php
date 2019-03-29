<?php

namespace App\Controller;

use App\Entity\Characters;
use App\Form\CharactersType;
use App\Repository\CharactersRepository;
use App\Upload\FileCharactersUpload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/characters")
 */
class CharactersController extends AbstractController
{
    /**
     * @Route("/", name="characters_index", methods={"GET"})
     */
    public function index(CharactersRepository $charactersRepository): Response
    {
        return $this->render('characters/index.html.twig', [
            'characters' => $charactersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="characters_new", methods={"GET","POST"})
     */
    public function new(Request $request,FileCharactersUpload $fileCharactersUpload): Response
    {
        $character = new Characters();
        $form = $this->createForm(CharactersType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileCharactersUpload->upload($character);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('characters_index');
        }

        return $this->render('characters/new.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="characters_show", methods={"GET"})
     */
    public function show(Characters $character): Response
    {
        return $this->render('characters/show.html.twig', [
            'character' => $character,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="characters_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Characters $character,FileCharactersUpload $fileCharactersUpload): Response
    {
        $form = $this->createForm(CharactersType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileCharactersUpload->upload($character);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('characters_index', [
                'id' => $character->getId(),
            ]);
        }

        return $this->render('characters/edit.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="characters_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Characters $character,FileCharactersUpload $fileCharactersUpload): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {
            if($fileCharactersUpload->removeFile($character) === true) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($character);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('characters_index');
    }
}
