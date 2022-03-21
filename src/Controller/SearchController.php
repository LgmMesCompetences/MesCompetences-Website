<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Posseder;
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

            $querys = array_map(function ($value) {return trim($value);}, $querys);
            dump($querys);

            /** @var \App\Repository\PossederRepository */
            $repo = $doctrine->getRepository(Posseder::class);

            $results = $repo->searchUsersByCompetences_native(json_encode($querys));

            dump($results);
        }
        else {
            $querys = [];
            $results = [];
        }

        return $this->render('static/search.html.twig', [
            'competences' => $competences,
            'querys' => $querys,
            'results' => $results,
        ]);       
    }
}
