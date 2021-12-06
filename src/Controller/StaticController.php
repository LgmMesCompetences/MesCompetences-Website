<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\SearchCompType;
use App\Entity\Competence;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        return $this->render('static/index.html.twig');
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request)
    {
        
        if($request->isMethod('POST')){ 
            $repo=$this->getDoctrine()->getRepository(Competence::class);
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                return $this->redirectToRoute('search');
            }
        }
           
        return $this->render('static/search.html.twig');
   
          
    }
}
