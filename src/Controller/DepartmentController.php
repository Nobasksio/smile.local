<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\SubscriberType;
use App\Repository\CategoryRepository;
use App\Repository\RenterRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends MainController
{
    /**
     * @Route("/department", name="department")
     */
    public function index(CategoryRepository $categoryRepository, RenterRepository $renterRepository)
    {
        $work_time = $this->getWorktime();
        $categories = $categoryRepository->findBy([],['sort'=> 'ASC']);
        $renters = $renterRepository->findBy(['active'=>true],['sort'=> 'ASC']);
        $form = $this->createForm(SubscriberType::class);
        return $this->render('departments.html.twig',
            [
                'categories'=> $categories,
                'renters' => $renters,
                'work_time' =>$work_time,
                'form' => $form->createView(),

            ]);
    }
    /**
     * @Route("admin/department", name="departments_list_admin")
     */
    public function adminList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBy([],['sort'=> 'ASC']);
        return $this->render('admin/department_list.html.twig',
            [
                'categories'=>$categories
            ]);
    }
    /**
     * @Route("/department/{id}", name="one_department")
     */
    public function department(Category $category, CategoryRepository $categoryRepository, RenterRepository $renterRepository)
    {
        $categories = $categoryRepository->findBy([],['sort'=> 'ASC']);
        $renters = $category->getRenters();
        $form = $this->createForm(SubscriberType::class);
        $work_time = $this->getWorktime();
        return $this->render('departments.html.twig',
            [
                'categories'=>$categories,
                'renters' => $renters,
                'this_category'=>$category,
                'work_time' =>$work_time,
                'form' => $form->createView()
            ]);
    }
    /**
     * @Route("admin/department/ajax", name="departments_list_ajax")
     */
    public function adminListAjax(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBy([],['sort'=> 'ASC']);
        $json = $this->json($categories);
        return $json;
    }
    /**
     * @Route("admin/department/new", name="department_admin_create")
     */
    public function create(CategoryRepository $categoryRepository, Request $request,ObjectManager $manager)
    {
        $Category = new Category();
        $form = $this->createForm(
            CategoryType::class,
            $Category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($Category);
            $manager->flush();

            return $this->redirect('/admin/department');
        }

        return $this->render('admin/new_department.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/department/redact/{id}", name="department_redact")
     */
    public function redact(Category $category, Request $request,ObjectManager $manager){

        $form = $this->createForm(
            CategoryType::class,
            $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            return $this->redirect('/admin/department');
        }

        return $this->render('admin/new_department.html.twig',[
            'form' => $form->createView(),
            'category' => $category
        ]);
    }
    /**
     * @Route("admin/department/delet/{id}", name="category_delet")
     */
    public function delete(Category $category)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('departments_list_admin');
    }
}
