<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;


class SubscriberController extends AbstractController
{
    /**
     * @Route("/admin/subscriber", name="subscriber_index", methods={"GET"})
     */
    public function index(SubscriberRepository $subscriberRepository): Response
    {
        return $this->render('subscriber/index.html.twig', [
            'subscribers' => $subscriberRepository->findby([],['date_subscribe'=> 'Desc']),
        ]);
    }

    /**
     * @Route("/ajax/subscriber/new", name="subscriber_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subscriber = new Subscriber();

        $email = $request->query->get('email');

        $subscriber->setEmail($email);
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscriber);
            $entityManager->flush();

            return new Response(1);
        } catch (\mysqli_sql_exception $exception){
            return new Response(0);
        }

    }

    /**
     * @Route("/admin/subscriber/{id}", name="subscriber_show", methods={"GET"})
     */
    public function show(Subscriber $subscriber): Response
    {
        return $this->render('subscriber/show.html.twig', [
            'subscriber' => $subscriber,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscriber_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Subscriber $subscriber): Response
    {
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscriber_index', [
                'id' => $subscriber->getId(),
            ]);
        }

        return $this->render('subscriber/edit.html.twig', [
            'subscriber' => $subscriber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/subscriber/delete/{id}", name="subscriber_delete", methods={"GET","DELETE"})
     */
    public function delete(Request $request, Subscriber $subscriber): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscriber);
            $entityManager->flush();


        return $this->redirectToRoute('subscriber_index');
    }

    /**
     * @Route("/admin/subscriber_download", name="subscriber_download", methods={"GET"})
     */
    public function download_subscribe(SubscriberRepository $sr){
        $subscribers = $sr->findAll();

        $name_file = new \DateTime('now');
        $name_file_text = $name_file->format('d.m.Y H.i.s');
        $name_file = $this->getParameter('myseting_place').'/'.$name_file_text.'.csv';

        $str_content = iconv("utf-8", "cp1251",'email;дата;активность');

        foreach ($subscribers as $subscriber){

            $email = iconv("utf-8", "cp1251",$subscriber->getEmail());
            $date = iconv("utf-8", "cp1251",$subscriber->getDateActivate()->format('d.m.Y H.i.s'));
            $active = $subscriber->getActivate();
            if ($active){
                $active = iconv("utf-8", "cp1251",'активен');
            } else {
                $active = iconv("utf-8", "cp1251",'не активен');
            }
            $str_content .= "\n".$email.";".$date.";"."$active";
        }

        $file_content = file_put_contents($name_file,$str_content);
        $file = $name_file;
        $response = new BinaryFileResponse($file);

        $response->headers->set('Content-Type', 'application/CSV');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $name_file_text.'.csv'
        );

        return $response;
 

    }
}
