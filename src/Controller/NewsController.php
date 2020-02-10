<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\News;
use App\Form\ActionRedactType;
use App\Form\ActionType;
use App\Form\NewsRedactType;
use App\Form\NewsType;
use App\Form\SubscriberType;
use App\Repository\ActionRepository;
use App\Repository\NewsRepository;
use App\Repository\RenterRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends MainController
{
    /**
     * @Route("/news", name="news")
     */
    public function index(NewsRepository $newsRepository,ActionRepository $actionRepository)
    {
        $work_time = $this->getWorktime();
        $news = $newsRepository->findby(['active'=>true],['date'=> 'Desc']);
        $actions = $actionRepository->findby(['active'=>true],['sort'=> 'ASC']);
        $form = $this->createForm(SubscriberType::class);
        return $this->render('news.html.twig', ['news'=>$news,
            'form'=>$form->createView(),
            'work_time' => $work_time,
            'actions'=>$actions]);
    }

    /**
     * @Route("/news/{id}", name="news_item")
     */
    public function newsItem($id,NewsRepository $newsRepository)
    {
        $work_time = $this->getWorktime();
        $form = $this->createForm(SubscriberType::class);
        $news = $newsRepository->findoneBy(['active'=>true,'id'=>$id]);
        return $this->render('new.html.twig',['news'=>$news,
            'work_time' => $work_time,
            'form'=>$form->createView()]);
    }
    /**
     * @Route("/action/{id}", name="action_item")
     */
    public function actionItem($id,ActionRepository $actionRepository)
    {
        $work_time = $this->getWorktime();
        $form = $this->createForm(SubscriberType::class);
        $action = $actionRepository->findoneBy(['active'=>true,'id'=>$id]);
        return $this->render('action.html.twig',['action'=>$action,
            'work_time' => $work_time,
            'form'=>$form->createView()]);
    }


    /**
     * @Route("admin/action_list", name="action_list_admin")
     */
    public function adminActionList(ActionRepository $actionRepository)
    {
        $actions = $actionRepository->findby([],['sort'=> 'ASC']);
        return $this->render('admin/actions/actions_list.html.twig',
            [
                'actions'=>$actions
            ]);
    }
    /**
     * @Route("admin/news_list", name="news_list_admin")
     */
    public function adminNewsList(NewsRepository $newsRepository)
    {
        $news = $newsRepository->findby([],['date'=> 'Desc']);;
        return $this->render('admin/news/news_list.html.twig',
            [
                'news'=>$news
            ]);
    }
    /**
 * @Route("admin/news/new", name="create_news")
 */
    public function createNews(Request $request, ObjectManager $manager)
    {
        $news = new News();
        $form = $this->createForm(
            NewsType::class,
            $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $preview = $form->get('preview')->getData();
            $previewName = $this->generateUniqueFileName() . '.' . $preview->guessExtension();

            $preview->move(
                $this->getParameter('upload_file'),
                $previewName
            );
            $news->setPreview($previewName);

            $image = $form->get('image')->getData();
            $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();

            $image->move(
                $this->getParameter('upload_file'),
                $imageName
            );
            $news->setImage($imageName);


            $manager->persist($news);
            $manager->flush();

            return $this->redirect('/admin/news_list');
        }

        return $this->render('admin/news/new_news.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("admin/news/redact/{id}", name="redact_news")
     */
    public function redactNews(News $news, Request $request, ObjectManager $manager)
    {

        $form = $this->createForm(
            NewsRedactType::class,
            $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $preview = $form->get('preview_upload')->getData();

            if (isset($preview) and $preview!=null){

                $previewName = $this->generateUniqueFileName() . '.' . $preview->guessExtension();
                $preview->move(
                    $this->getParameter('upload_file'),
                    $previewName
                );
                $news->setPreview($previewName);
            }

            $image = $form->get('image_upload')->getData();

            if (isset($image) and $image!=null) {

                $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('upload_file'),
                    $imageName
                );
                $news->setImage($imageName);

            }

            $manager->persist($news);
            $manager->flush();

            return $this->redirect('/admin/news_list');
        }

        return $this->render('admin/news/redact_news.html.twig',[
            'form' => $form->createView(),
            'news' => $news
        ]);

    }

    /**
     * @Route("admin/action/new", name="create_action")
     */
    public function createAction(Request $request, ObjectManager $manager,RenterRepository $renterRepository)
    {

        $action = new Action();
        $form = $this->createForm(
            ActionType::class,
            $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $preview = $form->get('photo_small')->getData();
            $previewName = $this->generateUniqueFileName() . '.' . $preview->guessExtension();

            $preview->move(
                $this->getParameter('upload_file'),
                $previewName
            );
            $action->setPhotoSmall($previewName);

            $image = $form->get('photo_big')->getData();
            $imageName = $this->generateUniqueFileName() . '.' . $image->guessExtension();

            $image->move(
                $this->getParameter('upload_file'),
                $imageName
            );
            $action->setPhotoBig($imageName);


            $renters = $form->get('renter_id')->getData();

            $action->addRenter($renters);


            $manager->persist($action);
            $manager->flush();

            return $this->redirect('/admin/action_list');
        }
        $renters = $renterRepository->findAll();
        return $this->render('admin/actions/new_action.html.twig',[
            'form' => $form->createView(),

        ]);

    }
    /**
     * @Route("admin/action/redact/{id}", name="redact_action")
     */
    public function redactAction(Action $action, Request $request, ObjectManager $manager,RenterRepository $renterRepository)
    {


        $form = $this->createForm(
            ActionRedactType::class,
            $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $preview = $form->get('photo_small_upload')->getData();

            if (isset($preview) and $preview!=null){

                $previewName = $this->generateUniqueFileName() . '.' . $preview->guessExtension();
                $preview->move(
                    $this->getParameter('upload_file'),
                    $previewName
                );
                $action->setPhotoSmall($previewName);
            }

            $image = $form->get('photo_big_upload')->getData();

            if (isset($image) and $image!=null){

                $previewName = $this->generateUniqueFileName() . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('upload_file'),
                    $previewName
                );
                $action->setPhotoBig($previewName);
            }

            $renters = $form->get('renter_id')->getData();

            $action->addRenter($renters);


            $manager->persist($action);
            $manager->flush();

            return $this->redirect('/admin/action_list');
        }
        $renters = $renterRepository->findAll();
        return $this->render('admin/actions/redact_action.html.twig',[
            'form' => $form->createView(),
            'action' => $action
        ]);

    }
    /**
 * @Route("admin/news/delet/{id}", name="news_delete")
 */
    public function deleteNews(News $news)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute('news_list_admin');
    }
    /**
     * @Route("admin/action/delet/{id}", name="action_delete")
     */
    public function deleteAction(Action $action)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($action);
        $entityManager->flush();

        return $this->redirectToRoute('action_list_admin');
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


}
