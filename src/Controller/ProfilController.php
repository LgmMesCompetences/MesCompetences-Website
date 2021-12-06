<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Competence;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $this->getDoctrine()->getManager();
        if ($request->get('id')!=null){
            $u = $doctrine->getRepository(Competence::class)->find($request->get('id'));
            $em->remove($u);
            $em->flush();
            return $this->redirectToRoute('profil');
        }
        $repocompetence = $this->getDoctrine()->getRepository(Competence::class);
        $competences = $repocompetence->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('profil/profile.html.twig', ['competences'=>$competences]);
    }

    #[Route('/modifcompetence/{id}', name: 'modifcompetence',requirements:["id"=>"\d+"])]
    public function modifCompetence(Request $request, int $id)
    {
        $competence=$this->getDoctrine()->getRepository(Competence::class)->find($id);

        $form = $this->createForm(AddCompetenceType::class,$competence);
        if($request->isMethod('POST')){ 
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em = $this-> getDoctrine()->getManager();
                $em->persist($competence);
                $em->flush();

                return $this->redirectToRoute('profil ');
                
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
