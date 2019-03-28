<?php

namespace App\Controller;

use App\Entity\UserProduct;
use App\Form\UserProductType;
use App\Repository\UserProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/product")
 */
class UserProductController extends AbstractController
{
    /**
     * @Route("/", name="user_product_index", methods={"GET"})
     */
    public function index(UserProductRepository $userProductRepository): Response
    {
        return $this->render('user_product/index.html.twig', [
            'user_products' => $userProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userProduct = new UserProduct();
        $form = $this->createForm(UserProductType::class, $userProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProduct);
            $entityManager->flush();

            return $this->redirectToRoute('user_product_index');
        }

        return $this->render('user_product/new.html.twig', [
            'user_product' => $userProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_product_show", methods={"GET"})
     */
    public function show(UserProduct $userProduct): Response
    {
        return $this->render('user_product/show.html.twig', [
            'user_product' => $userProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserProduct $userProduct): Response
    {
        $form = $this->createForm(UserProductType::class, $userProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_product_index', [
                'id' => $userProduct->getId(),
            ]);
        }

        return $this->render('user_product/edit.html.twig', [
            'user_product' => $userProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserProduct $userProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_product_index');
    }
}
