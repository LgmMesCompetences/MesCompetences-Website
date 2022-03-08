<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Competence;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/admin/competences')]
class AdminCompetencesController extends AbstractController
{
    #[Route('', name: 'app_admin_competences_dash')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $competences = $doctrine->getRepository(Competence::class)->findBy(array(), array('id'=>'ASC'));
    
        return $this->render('admin/dashboard-competences.html.twig', [
            'competences' => $competences
        ]);
    }
        #[Route('/modif-competences/{id}', name: 'app_admin_competences_modif',  requirements: ["id"=>"\d+"])]
        public function modifCompetences(Request $request, Competence $competence, ManagerRegistry $doctrine): Response
        {    
            $form = $this->createForm(UpdateCompetenceType::class, $competence);
    
            if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $em = $doctrine->getManager();
                    $em->persist($competence);
                    $em->flush();
                    return $this->redirectToRoute('app_admin_competences_dash');
                }
            }
            return $this->render('admin/modif-competences.html.twig', ['form'=>$form->createView()]);
        }
}
