<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 27/04/2019
 * Time: 19:29
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class indexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
    /**
     * @Route("/contacts", name="contacts")
     */
    public function contact()
    {
        return $this->render('contact.html.twig');
    }
    /**
     * @Route("/for_renter", name="for_renter")
     */
    public function forRenter()
    {
        return $this->render('plain_page.html.twig');
    }
    /**
     * @Route("/ad", name="ad")
     */
    public function ad()
    {
        return $this->render('plain_page.html.twig');
    }

    /**
     * @Route("/our_map", name="our_map")
     */
    public function ourMap()
    {
        return $this->render('plain_page.html.twig');
    }
    /**
     * @Route("/path", name="path")
     */
    public function path()
    {
        return $this->render('path.html.twig');
    }

}