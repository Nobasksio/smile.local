<?php

namespace App\Controller;

use App\Entity\MapPlace;
use App\Repository\MapPlaceRepository;
use App\Repository\RenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MapplaceController extends AbstractController
{
    /**
     * @Route("/ajax/mapplace/{id}", name="mapplace_ajax")
     */
    public function index(MapPlace $mapPlace,RenterRepository $rr)
    {
        $renter = $mapPlace->getRenter();
        if (isset($renter)) {
            $id = $renter->getId();

            $renter2 = $rr->findOneBy(['id' => $id]);

            $name = $renter2->getName();
            $description = $renter2->getDescription();
            $link = $renter2->getLink();
            $array_out = array('name' => $name,
                'link' => $link,
                'description' => $description,
                'id' => $id);
        } else {
            $array_out = array('name' => 0,
                'link' => 0,
                'description' => 0,
                'id' => 0);
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($array_out, 'json');

        return new Response($jsonContent);
    }
}
