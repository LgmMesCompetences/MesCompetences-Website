<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Competence;
use App\Entity\Posseder;
use Doctrine\Persistence\ManagerRegistry;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(Request $request, ManagerRegistry $doctrine): Response
    {
        $repoPosseder = $this->getDoctrine()->getRepository(Posseder::class);
        $posseders = $repoPosseder->findBy(['user' => $this->getUser()]);
        $filteredCompetences = [];

        /** @var \App\Entity\Posseder $posseder */
        foreach ($posseders as $posseder) {
            $mainLib = $posseder->getCompetence()->getMainComp() == null ? $posseder->getCompetence()->getLibelle() : $posseder->getCompetence()->getMainComp()->getLibelle();
            if (!array_key_exists($mainLib, $filteredCompetences)) {
                $filteredCompetences[$mainLib] = [];
            }

            array_push($filteredCompetences[$mainLib], $posseder->getCompetence());
        }

        dump($filteredCompetences);

        $sortedCompetences = [];
        foreach ($filteredCompetences as $key => $group) {
            uasort($group, function (Competence $a, Competence $b) {
                if ($a->getLevel() > $b->getLevel()) {
                    return 1;
                } elseif ($a->getLevel() < $b->getLevel()) {
                    return -1;
                } else {
                    return 0;
                }
            });

            $sortedCompetences[$key] = $group;
        }

        dump($sortedCompetences);

        return $this->render('profil/profil.html.twig',
            [
                'competences' => $sortedCompetences
            ]
        );
    }

    #[Route('/modifcompetence/{id}', name: 'modifcompetence',requirements:["id"=>"\d+"])]
    public function modifCompetence(Request $request, int $id): Response
    {
        $competence=$this->getDoctrine()->getRepository(Competence::class)->find($id);

        $form = $this->createForm(AddCompetenceType::class,$competence);
        if($request->isMethod('POST')){ 
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em = $this-> getDoctrine()->getManager();
                $em->persist($competence);
                $em->flush();

                return $this->redirectToRoute('profil');
                
            }
        }               
          return $this->render('profil/modifcompetence.html.twig', ['form'=>$form->createView()]);  
    }

    #[Route('/ajoutcompetence', name: 'ajoutcompetence')]
    public function ajoutCompetence(Request $request)
    {          
          return $this->render('profil/ajoutcompetence.html.twig', []);  
    }
}
