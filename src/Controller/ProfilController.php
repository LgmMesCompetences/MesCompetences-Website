<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Competence;
use App\Entity\Posseder;
use App\Form\UpdateEmailType;
use App\Form\UpdatePasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        $posseders = $user->getPosseders();
        $filteredCompetences = [];

        /** @var \App\Entity\Posseder $posseder */
        foreach ($posseders as $posseder) {
            $mainLib = $posseder->getCompetence()->getMainComp() == null ? $posseder->getCompetence()->getLibelle() : $posseder->getCompetence()->getMainComp()->getLibelle();
            if (!array_key_exists($mainLib, $filteredCompetences)) {
                $filteredCompetences[$mainLib] = [];
            }

            array_push($filteredCompetences[$mainLib], $posseder->getCompetence());
        }

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

        $passwordForm = $this->createForm(UpdatePasswordType::class);
        $emailForm = $this->createForm(UpdateEmailType::class);

        if($request->isMethod('POST')){
            $passwordForm->handleRequest($request);
            if($passwordForm->isSubmitted() && $passwordForm->isValid()){
                $newPassword = $passwordHasher->hashPassword($user, $passwordForm->get('newPassword')->getData());
                $user->setPassword($newPassword);
                $doctrine->getManager()->flush();
                $this->addFlash('success', 'Your password have been updated.');

                return $this->redirectToRoute('profil');
            }

            $emailForm->handleRequest($request);
            if($emailForm->isSubmitted() && $emailForm->isValid()){
                $user->setEmail($emailForm->get('email')->getData());
                $doctrine->getManager()->flush();
                $this->addFlash('success', 'Your email have been updated.');

                return $this->redirectToRoute('profil');
            }
        }

        return $this->render('profil/profil.html.twig',
            [
                'competences' => $sortedCompetences,
                'passwordForm' => $passwordForm->createView(),
                'emailForm' => $emailForm->createView(),
            ]
        );
    }

    #[Route('/profil/addcompetence/{id}', name: 'profil_add_comp')]
    public function addComp(Competence $competence, ManagerRegistry $doctrine): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        $already = $doctrine->getRepository(Posseder::class)->findBy(['competence'=>$competence->getId(), 'user'=>$user->getId()], [], 1);

        if (empty($already)) {
            $posseder = new Posseder();
            $posseder->setCompetence($competence);
            $doctrine->getManager()->persist($posseder);
            $doctrine->getManager()->flush();

            return $this->json([], Response::HTTP_CREATED);
        }
        else {
            return $this->json([], Response::HTTP_NOT_MODIFIED);
        }
    }
}
