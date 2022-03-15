<?php

namespace App\Command;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

#[AsCommand(
    name: 'app:sql:fonc',
    description: 'Add a short description for your command',
)]
class SqlFoncCommand extends Command
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();
        $this->doctrine = $doctrine;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $finder = new Finder();
        $finder->in('src/Sql');
        $finder->name('stored_functions.sql');

        foreach( $finder as $file ){
            $content = $file->getContents();



            $stmt = $this->doctrine->getConnection()->prepare($content);
            $stmt->execute();
        }

        return Command::SUCCESS;
    }
}
