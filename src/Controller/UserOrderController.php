<?php

namespace App\Controller;

use App\Entity\UserOrder;
use App\Form\UserOrderType;
use App\Repository\UserOrderRepository;
use App\Repository\UserProductRepository;
use App\Security\AppAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user-order")
 */
class UserOrderController extends AbstractController
{
    /**
     * @Route("/", name="user_order_index", methods={"GET"})
     */
    public function index(UserOrderRepository $userOrderRepository): Response
    {
        return $this->render('user_order/index.html.twig', [
            'user_orders' => $userOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userOrder = new UserOrder();
        $form = $this->createForm(UserOrderType::class, $userOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userOrder);
            $entityManager->flush();

            return $this->redirectToRoute('user_order_index');
        }

        return $this->render('user_order/new.html.twig', [
            'user_order' => $userOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_order_show", methods={"GET"})
     */
    public function show(UserOrder $userOrder, UserProductRepository $userProductRepository): Response
    {
        $this->denyAccessUnlessGranted(AppAccess::USERORDERSHOW, $userProductRepository->findBy(array('userOrder' => $userOrder)));

        return $this->render('user_order/show.html.twig', [
            'user_order' => $userOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserOrder $userOrder, UserProductRepository $userProductRepository): Response
    {
        $this->denyAccessUnlessGranted(AppAccess::USERORDEREDIT, $userProductRepository->findBy(array('userOrder' => $userOrder)));

        $form = $this->createForm(UserOrderType::class, $userOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_order_index', [
                'id' => $userOrder->getId(),
            ]);
        }

        return $this->render('user_order/edit.html.twig', [
            'user_order' => $userOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserOrder $userOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_order_index');
    }
}
