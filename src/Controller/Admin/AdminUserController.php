<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\UpdateUserType;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/admin/user')]
class AdminUserController extends AbstractController
{
    #[Route('', name: 'app_admin_user_dash')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findBy(array(), array('id'=>'ASC'));

        return $this->render('admin/dashboard-user.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/modif-user/{id}', name: 'app_admin_user_modif',  requirements: ["id"=>"\d+"])]
    public function modifUtilisateur(Request $request, User $user, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(UpdateUserType::class, $user);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_admin_user_dash');
            }
        }

        return $this->render('admin/modif-user.html.twig', ['form'=>$form->createView()]);

    }
}
