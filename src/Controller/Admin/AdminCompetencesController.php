<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Competence;



#[Route('/admin/competences')]
class AdminCompetencesController extends AbstractController
{
    #[Route('', name: 'app_admin_competences_dash')]
    public function index(): Response
    {
        
        $doctrine = $this->getDoctrine();
        $competences = $doctrine->getRepository(Competence::class)->findBy(array(), array('id'=>'ASC'));
    
        return $this->render('admin/dashboard-competences.html.twig', [
            'competences' => $competences
        ]);
    }
        #[Route('/modif-competences/{id}', name: 'app_admin_competences_modif',  requirements: ["id"=>"\d+"])]
        public function modifCompetences(Request $request, int $id): Response
        {
           
            $competence = $this->getDoctrine()->getRepository(Competence::class)->find($id);
    
            $form = $this->createForm(UpdateCompetenceType::class, $competence);
    
            if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($competence);
                    $em->flush();
                    return $this->redirectToRoute('app_admin_competences_dash');
                }
            }
            return $this->render('admin/modif-competences.html.twig', ['form'=>$form->createView()]);
        }
}
