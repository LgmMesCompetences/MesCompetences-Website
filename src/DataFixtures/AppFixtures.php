<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Posseder;
use App\Entity\Competence;

class AppFixtures extends Fixture
{

    private $faker;

    public function __construct(){
        $this->faker=Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<30;$i++){
            $user = new User();
            $user->setEmail($this->faker->email())
                ->setPassword("$2y$13$7ecAj2KlYsHlOY19.Bf.zOr1Vs4U3aaQUobHvUbYW/L8I9.He1p1O")
                ->setDateInscription($this->faker->datetime());

            $competence = new Competence();
            $competence->setLibelle($this->faker->word())
                ->setLevel("1");
 
            $manager->persist($user);
            $manager->persist($competence);
        }
        $manager->flush();
    }
}
