<?php

namespace App\Controller;

use App\Entity\Competence;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, ManagerRegistry $doctrine)
    {
        $competences = $doctrine->getManager()->getRepository(Competence::class)->findAll();
        dump($competences);
        
        $query = $request->query->get('query');
        dump($query);

        if ($query) {
            $querys = explode(',', $query);
            dump($querys);

            $querys = array_map(function ($value) {return trim($value);}, $querys);
            dump($querys);
        }
        else {
            $querys = [];
        }

        return $this->render('static/search.html.twig', [
            'competences' => $competences,
            'querys' => $querys,
        ]);       
    }
}
