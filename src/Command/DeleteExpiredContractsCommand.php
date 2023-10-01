<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:delete-expired-contracts',
    description: 'Delete every users with expired contracts',
)]
class DeleteExpiredContractsCommand extends Command
{
    public function __construct(private UserRepository $UserRepo, private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $usrToDelete = $this->UserRepo->findWithExpiredContracts();
        foreach ($usrToDelete as $key => $value) {
            # code...
            $this->em->remove($value);
        }
        $this->em->flush();
        $io->success('database succesfully updated!');
        return Command::SUCCESS;
    }
}
