<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index()
    {
        return $this->render('news.html.twig');
    }

    /**
     * @Route("/news/{name}", name="news_item")
     */
    public function newsItem($name)
    {
        return $this->render('action.html.twig');
    }
}
