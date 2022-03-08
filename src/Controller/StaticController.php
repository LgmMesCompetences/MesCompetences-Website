<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(Request $request): Response
    {
        return $this->render('static/index.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(Request $request): Response
    {
        return $this->render('static/mentions.html.twig');
    }

    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(Request $request): Response
    {
        return $this->render('static/cgu.html.twig');
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request)
    {   
        return $this->render('static/search.html.twig');       
    }
}
