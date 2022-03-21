<?php

namespace App\Command;

use App\Entity\Posseder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sql:test',
    description: 'Add a short description for your command',
)]
class SqlTestCommand extends Command
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();
        $this->doctrine = $doctrine;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var \App\Repository\PossederRepository */
        $repo = $this->doctrine->getManager()->getRepository(Posseder::class);
        $results = $repo->searchUsersByCompetences_doctrine('["SubComp"]');

        dd($results);

        return Command::SUCCESS;
    }
}
