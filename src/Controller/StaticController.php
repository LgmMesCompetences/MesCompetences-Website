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
        return $this->render('static/mentions-legales.html.twig');
    }

    #[Route('/conditions-generales-d-utilisation', name: 'app_cgu')]
    public function cgu(Request $request): Response
    {
        return $this->render('static/cgu.html.twig');
    }

    #[Route('/politique-de-confidantialite', name: 'app_politique')]
    public function politique(Request $request): Response
    {
        return $this->render('static/politique.html.twig');
    }
}
