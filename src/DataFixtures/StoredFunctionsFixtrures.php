<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class StoredFunctionsFixtures extends Fixture
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $finder = new Finder();
        $finder->in('src/Sql');
        $finder->name('stored_functions.sql');

        foreach( $finder as $file ){
            $content = $file->getContents();

            $stmt = $this->doctrine->getConnection()->prepare($content);
            $stmt->execute();
        }
    }
}
