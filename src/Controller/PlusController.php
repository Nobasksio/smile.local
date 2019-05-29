<?php

namespace App\Controller;

use App\Entity\Plus;
use App\Form\PlusType;
use App\Repository\PlusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/plus")
 */
class PlusController extends AbstractController
{
    /**
     * @Route("/", name="plus_index", methods={"GET"})
     */
    public function index(PlusRepository $plusRepository): Response
    {
        return $this->render('plus/index.html.twig', [
            'pluses' => $plusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="plus_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plus = new Plus();
        $form = $this->createForm(PlusType::class, $plus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plus);
            $entityManager->flush();

            return $this->redirectToRoute('plus_index');
        }

        return $this->render('plus/new.html.twig', [
            'plus' => $plus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plus_show", methods={"GET"})
     */
    public function show(Plus $plus): Response
    {
        return $this->render('plus/show.html.twig', [
            'plus' => $plus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plus_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plus $plus): Response
    {
        $form = $this->createForm(PlusType::class, $plus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plus_index', [
                'id' => $plus->getId(),
            ]);
        }

        return $this->render('plus/edit.html.twig', [
            'plus' => $plus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plus_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plus $plus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plus_index');
    }
}
