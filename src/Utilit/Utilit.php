<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 16/05/2019
 * Time: 22:02
 */

namespace App\Utilit;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Utilit extends AbstractController
{
    public function getWorktime(){
        $array_week = array(
            0=>'ПН',
            1=>'ВТ',
            2=>'СР',
            3=>'ЧТ',
            4=>'ПТ',
            5=>'СБ',
            6=>'ВС',
        );
        $place = $this->getParameter('myseting_place');
        $worktime_content = file_get_contents($place.'/worktime.txt');
        $worktime_arr = explode("\n", $worktime_content);
        $work_time = [];

        foreach ($worktime_arr as $index=>$item){
            $day_arr = explode(";", $item);
            if (count($day_arr)>1) {
                $day_arr_time = explode("-", $day_arr[1]);
                $work_time[$array_week[$index]] = ['start' => $day_arr_time[0], 'finish' => $day_arr_time[1]];
            }
        }

        return $work_time;
    }


}