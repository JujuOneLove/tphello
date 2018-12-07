<?php

namespace App\Controller;

use App\Entity\ItemType;
use App\Form\ItemTypeType;
use App\Repository\ItemTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/itemtype")
 */
class ItemTypeController extends AbstractController
{
    /**
     * @Route("/", name="item_type_index", methods="GET")
     */
    public function index(ItemTypeRepository $itemTypeRepository): Response
    {
        return $this->render('item_type/index.html.twig', ['item_types' => $itemTypeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="item_type_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $itemType = new ItemType();
        $form = $this->createForm(ItemTypeType::class, $itemType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($itemType);
            $em->flush();

            return $this->redirectToRoute('item_type_index');
        }

        return $this->render('item_type/new.html.twig', [
            'item_type' => $itemType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_type_show", methods="GET")
     */
    public function show(ItemType $itemType): Response
    {


        return $this->render('item_type/show.html.twig', ['item_type' => $itemType]);
    }

    /**
     * @Route("/{id}/edit", name="item_type_edit", methods="GET|POST")
     */
    public function edit(Request $request, ItemType $itemType): Response
    {
        $form = $this->createForm(ItemTypeType::class, $itemType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_type_index', ['id' => $itemType->getId()]);
        }

        return $this->render('item_type/edit.html.twig', [
            'item_type' => $itemType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_type_delete", methods="DELETE")
     */
    public function delete(Request $request, ItemType $itemType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemType->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($itemType);
            $em->flush();
        }

        return $this->redirectToRoute('item_type_index');
    }
}
