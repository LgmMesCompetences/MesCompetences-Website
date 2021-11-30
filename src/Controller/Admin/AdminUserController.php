<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;


#[Route('/admin/user')]
class AdminUserController extends AbstractController
{
    #[Route('', name: 'app_admin_user_dash')]
    public function index(): Response
    {
        $doctrine = $this->getDoctrine();
        $users = $doctrine->getRepository(User::class)->findBy(array(), array('id'=>'ASC'));

        return $this->render('admin/dashboard-user.html.twig', [
            'users' => $users
        ]);
    }
}
