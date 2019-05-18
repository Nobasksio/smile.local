<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 27/04/2019
 * Time: 19:29
 */

namespace App\Controller;

use App\Form\SubscriberType;
use App\Repository\ActionRepository;
use App\Repository\NewsRepository;
use App\Repository\PlusRepository;
use App\Repository\RenterRepository;
use App\Repository\SliderRepository;
use App\Utilit\Utilit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class indexController extends MainController
{
    /**
     * @Route("/", name="index")
     */
    public function index(NewsRepository $newsRepository,
                          ActionRepository $actionRepository,
                          RenterRepository $renterRepository,
                          PlusRepository $plusRepository,
                          SliderRepository $sliderRepository)
    {
        $news = $newsRepository->findAll(['active'=>true],['date'=> 'Desc']);
        $actions = $actionRepository->findby(['active'=>true],['sort'=> 'ASC']);
        $renters = $renterRepository->findby(['active'=>true],['sort'=> 'ASC']);
        $sliders = $sliderRepository->findby(['active'=>true],['sort'=> 'ASC']);
        $form = $this->createForm(SubscriberType::class);

        $place = $this->getParameter('myseting_place');
        $work_time = $this->getWorktime();
        $about = file_get_contents($place.'/about.txt');
        return $this->render('index.html.twig',['news'=>$news,
            'actions'=>$actions,
            'renters' => $renters,
            'about' => $about,
            'form' => $form->createView(),
            'pluses' => $plusRepository->findby(['active'=>true],['sort'=> 'ASC']),
            'work_time'=>$work_time,
            'sliders'=>$sliders]);
    }


    /**
     * @Route("/our_map", name="our_map")
     */
    public function ourMap()
    {   $work_time = $this->getWorktime();
        return $this->render('our_map.html.twig',['work_time'=>$work_time]);
    }

    /**
     * @Route("/our_map/{floor}/{renter_id}", name="show_on_map")
     */
    public function showOnMap($floor,$renter_id,RenterRepository $rr)
    {
        $work_time = $this->getWorktime();
        $renter = $rr->find($renter_id);
        return $this->render('our_map.html.twig',[
            'renter' => $renter,
            'work_time'=>$work_time,
            'floor' => $floor
            ]);
    }
    /**
     * @Route("/path", name="path")
     */
    public function path()
    {
        $place = $this->getParameter('myseting_place');
        $work_time = $this->getWorktime();


        $file_content = file_get_contents($place.'/seting.txt');
        $parking = file_get_contents($place.'/parking.txt');

        $arr_str = explode("\n", $file_content);

        $transport = [];

        foreach ($arr_str as $item){
            $name_arr = explode(":", $item);
            $arr_transport = @explode(";",@$name_arr[1]);
            $arr_transport = array_diff($arr_transport, array(''));
            $transport[@$name_arr[0]] = $arr_transport;
        }


        return $this->render('path.html.twig',
            ['buses'=>$transport['bus'],
                'tramvais'=>$transport['tramvai'],
                'troleibuses'=>$transport['troleibus'],
                'work_time'=>$work_time,
                'parking'=>$parking
            ]);
    }

}