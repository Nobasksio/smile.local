<?php

namespace App\Controller;

use App\Entity\Renter;
use App\Form\RenterType;
use App\Form\RenterRedactType;
use App\Repository\MapPlaceRepository;
use App\Repository\RenterRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RenterController extends MainController
{

    /**
     * @Route("/admin/renter/list", name="renter_list_admin")
     */
    public function list(RenterRepository $renterRepository)
    {
        $rennters = $renterRepository->findBy([],['sort'=> 'ASC']);
        return $this->render('admin/renters/renter_list.html.twig',[
            'renters' =>$rennters
        ]);
    }
    /**
     * @Route("/ajax/renter/{id}", name="renter_ajax")
     */
    public function renter(Renter $renter){
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];


        $serializer = new Serializer($normalizers, $encoders);


        $jsonContent = $serializer->serialize($renter, 'json',['ignored_attributes' => ['actions','categories','mapPlace','news']]);
        $response = new JsonResponse($jsonContent);
        return $response;
    }
    /**
     * @Route("/admin/renter/new", name="renter_admin_new")
     */
    public function createRenter(Request $request, ObjectManager $manager)
    {

        $renter = new Renter();
        $form = $this->createForm(
            RenterType::class,
            $renter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $logo = $form->get('logo')->getData();
            $logo_name = $this->generateUniqueFileName() . '.' . $logo->guessExtension();

            $logo->move(
                $this->getParameter('upload_file'),
                $logo_name
            );
            $renter->setLogo($logo_name);

            $logo_grey = $form->get('logo_grey')->getData();
            $logo_grey_name = $this->generateUniqueFileName() . '.' . $logo_grey->guessExtension();

            $logo_grey->move(
                $this->getParameter('upload_file'),
                $logo_grey_name
            );
            $renter->setLogoGrey($logo_grey_name);

            $image = $form->get('image')->getData();
            $image_name = $this->generateUniqueFileName() . '.' . $image->guessExtension();

            $image->move(
                $this->getParameter('upload_file'),
                $image_name
            );
            $renter->setImage($image_name);

            $categories = $form->get('categories')->getData();

            //$renter->addCategory($categories);

            $manager->persist($renter);
            $manager->flush();

            return $this->redirect('/admin/renter/list');
        }

        return $this->render('admin/renters/new_renter.html.twig',[
            'form' => $form->createView(),

        ]);

    }
    /**
     * @Route("/admin/renter/redact/{id}", name="renter_redact")
     */
    public function renterRedact(Renter $renter, Request $request, ObjectManager $manager,MapPlaceRepository $mpr){


        $form = $this->createForm(
            RenterRedactType::class,
            $renter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $logo = $form->get('logo_upload')->getData();

            if (isset($logo) and $logo!=null) {
                $logo_name = $this->generateUniqueFileName() . '.' . $logo->guessExtension();

                $logo->move(
                    $this->getParameter('upload_file'),
                    $logo_name
                );
                $renter->setLogo($logo_name);
            }

            $logo_grey = $form->get('logo_grey_upload')->getData();
            if (isset($logo_grey) and $logo_grey!=null) {
                $logo_grey_name = $this->generateUniqueFileName() . '.' . $logo_grey->guessExtension();

                $logo_grey->move(
                    $this->getParameter('upload_file'),
                    $logo_grey_name
                );
                $renter->setLogoGrey($logo_grey_name);
            }

            $image = $form->get('image_upload')->getData();
            if (isset($image) and $image!=null) {
                $image_name = $this->generateUniqueFileName() . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('upload_file'),
                    $image_name
                );
                $renter->setImage($image_name);
            }


            $categories = $form->get('categories')->getData();


            $map_place = $mpr->findOneBy(['renter'=>$renter]);

            if ($map_place) {
                $map_place->setRenter(null);
                $manager->persist($map_place);
            }

            $manager->persist($renter);
            $manager->flush();

            return $this->redirect('/admin/renter/list');
        }

        return $this->render('admin/renters/redact_renter.html.twig',[
            'form' => $form->createView(),
            'renter' => $renter
        ]);
    }
    /**
     * @Route("admin/renter/delet/{id}", name="renter_delete")
     */
    public function delete(Renter $renter): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($renter);
            $entityManager->flush();

        return $this->redirectToRoute('renter_list_admin');
    }

    /**
     * @Route("/renter/{id}", name="renter_show")
     */
    public function renter_show(Renter $renter): Response
    {
        $work_time = $this->getWorktime();
        return $this->render('renter.html.twig',[
            'renter' =>$renter,
            'work_time' => $work_time,
        ]);

    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
