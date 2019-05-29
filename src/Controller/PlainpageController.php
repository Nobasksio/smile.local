<?php

namespace App\Controller;

use App\Entity\Plainpage;
use App\Form\PlainpageType;
use App\Form\SubscriberType;
use App\Repository\PlainpageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PlainpageController extends MainController
{
    /**
     * @Route("/admin/plainpage/", name="plainpage_index", methods={"GET"})
     */
    public function index(PlainpageRepository $plainpageRepository): Response
    {
        return $this->render('plainpage/index.html.twig', [
            'plainpages' => $plainpageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/plainpage/new", name="plainpage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plainpage = new Plainpage();
        $form = $this->createForm(PlainpageType::class, $plainpage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plainpage);
            $entityManager->flush();

            return $this->redirectToRoute('plainpage_index');
        }

        return $this->render('plainpage/new.html.twig', [
            'plainpage' => $plainpage,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/plainpage/{linkName}", name="plainpage_show", methods={"GET"})
     */
    public function show($linkName, PlainpageRepository $pr): Response
    {
        $work_time = $this->getWorktime();
        $plainpage = $pr->findoneBy(['link_name' => $linkName, 'active'=>true]);
        $form = $this->createForm(SubscriberType::class);
        return $this->render('plainpage/show.html.twig', [
            'plainpage' => $plainpage,
            'work_time' => $work_time,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/plainpage/{id}/edit", name="plainpage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plainpage $plainpage): Response
    {
        $form = $this->createForm(PlainpageType::class, $plainpage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plainpage_index', [
                'id' => $plainpage->getId(),
            ]);
        }

        return $this->render('plainpage/edit.html.twig', [
            'plainpage' => $plainpage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/plainpage/delete/{id}", name="plainpage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plainpage $plainpage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plainpage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plainpage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plainpage_index');
    }
}
