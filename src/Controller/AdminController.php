<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 02/05/2019
 * Time: 19:01
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserRedactType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(){

            return $this->render('admin/index.html.twig');

    }

    /**
     * @Route("/admin/path/redact", name="path_redact")
     */
    public function path(Request $request){

        $place = $this->getParameter('myseting_place');

        $file_content = file_get_contents($place.'/seting.txt');

        $arr_str = explode("\n", $file_content);

        $transport = [];

        foreach ($arr_str as $item){
            $name_arr = explode(":", $item);
            $arr_transport = @explode(";",@$name_arr[1]);
            $arr_transport = array_diff($arr_transport, array(''));
            $transport[@$name_arr[0]] = $arr_transport;
        }

        $parking = file_get_contents($place.'/parking.txt');

        return $this->render('admin/redact_transport.html.twig',
            ['buses'=>$transport['bus'],
                'tramvais'=>$transport['tramvai'],
                'troleibuses'=>$transport['troleibus'],
                'parking'=>$parking
                ]);
    }
    /**
     * @Route("/ajax/path/update", name="path_update")
     */
    public function path_update(Request $request){

        $place = $this->getParameter('myseting_place');

        $str_transport = '';
        $buses = $request->request->get('buses');
        $tramvais = $request->request->get('tramvais');
        $troleibuses = $request->request->get('troleibuses');
        $parking = $request->request->get('parking');
        $str_transport = 'bus:'.$this->clear_str($buses) . "\n";
        $str_transport .= 'tramvai:'. $this->clear_str($tramvais) . "\n";
        $str_transport .= 'troleibus:'. $this->clear_str($troleibuses). "\n";


        file_put_contents($place.'/seting.txt',$str_transport);
        file_put_contents($place.'/parking.txt',$parking);

        return new Response(1);
    }

    /**
     * @Route("/admin/common/redact", name="common_redact")
     */
    public function common(Request $request){

        $place = $this->getParameter('myseting_place');

        $file_content = file_get_contents($place.'/contact.txt');
        $arr_str = explode("\n", $file_content);
        $contact = [];
        foreach ($arr_str as $item){
            $item_arr = explode(":", $item);
            $contact[$item_arr[0]] = $item_arr[1];
        }

        $about = file_get_contents($place.'/about.txt');

        $worktime_content = file_get_contents($place.'/worktime.txt');
        $worktime_arr = explode("\n", $worktime_content);
        $work_time = [];
        foreach ($worktime_arr as $item){
            $day_arr = explode(";", $item);
            if (count($day_arr)>1) {
                $day_arr_time = explode("-", $day_arr[1]);
                $work_time[$day_arr[0]] = ['start' => $day_arr_time[0], 'finish' => $day_arr_time[1]];
            }
        }

        return $this->render('admin/redact_common.html.twig',
            ['phone'=>$contact['phone'],
                'name_press'=>$contact['name'],
                'mail_press'=>$contact['mail'],
                'about'=>$about,
                'work_time'=>$work_time
            ]);
    }
    /**
     * @Route("/ajax/common/update", name="common_update")
     */
    public function common_update(Request $request){

        $place = $this->getParameter('myseting_place');

        $array_week = array(
            1=>'Понедельник',
            2=>'Вторник',
            3=>'Среда',
            4=>'Четверг',
            5=>'Пятница',
            6=>'Суббота',
            7=>'Воскресенье',
        );
        $str_transport = '';
        $about = $request->query->get('about');
        $phone = $request->query->get('phone');
        $name_press = $request->query->get('name_press');
        $mail_press = $request->query->get('mail_press');
        $contact_str = 'phone:'.$phone."\n"."name:".$name_press."\n"."mail:".$mail_press;
        $work_time = '';
        for($i=1;$i<8;$i++){

            $time_start = $request->query->get('time_start'.$i);
            $time_finish = $request->query->get('time_finish'.$i);
            $work_time .= $array_week[$i].';'.$time_start.'-'.$time_finish."\n";
        }


        file_put_contents($place.'/worktime.txt',$work_time);
        file_put_contents($place.'/about.txt',$about);
        file_put_contents($place.'/contact.txt',$contact_str);
        return new Response(1);
    }


    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils){
        return $this->render('admin/login.html.twig',[
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'=>$authenticationUtils->getLastAuthenticationError()]);
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){
        return $this->render('auth/index.html.twig');
    }

    /**
     * @Route("/admin/user_list", name="user_list")
     */
    public function user_list(UserRepository $ur){
        $users = $ur->findBy([],['id'=> 'ASC']);
        return $this->render('admin/user_list.html.twig',[
            'users'=>$users
        ]);
    }
    /**
     * @Route("/admin/user_redact/{id}", name="user_redact")
     */
    public function user_redact(User $user, Request $request, ObjectManager $manager,UserPasswordEncoderInterface $passwordEncoder){

        $form = $this->createForm(
            UserRedactType::class,
            $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if ($user->getPlainPassword() != '' and $user->getPlainPassword()!=null) {
                $password = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
                $user->setPassword($password);
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirect('/admin');
        }
        return $this->render('admin/redact_user.html.twig',[
            'user'=>$user,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("admin/user/delet/{id}", name="user_delete")
     */
    public function deleteAction(User $user)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_list');
    }

    public function clear_str($str){

        $str = str_replace(' ', '', $str);
        $str = str_replace(',', ';', $str);


        return $str;
    }

}