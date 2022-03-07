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
    public function profil(): Response
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

        return $this->render('profil/profil.html.twig',
            [
                'competences' => $sortedCompetences
            ]
        );
    }
}
