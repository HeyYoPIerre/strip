<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;


#[AsCommand(
    name: 'app:create-admin',
    description: 'Génère un profil administrateur. !pensez à entrer Username et Mdp!',
)]
class CreateAdminCommand extends Command
{
    private ?SymfonyStyle $io = null; // $io peut être de type SymfonyStyle ou null.
    private $em;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $repository
        )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'username')
            ->addArgument('password', InputArgument::REQUIRED, 'password')
            ->addOption('admin', null, InputOption::VALUE_NONE, '--role');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->em = $this->repository->getEntityManager();

    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        if(!$username){
            $username = $this->io->ask("username");
            $input->setArgument('username', $username);
        }
        
        $password = $input->getArgument('password');
        if(!$password){
            $password = $this->io->askHidden("password");
            $input->setArgument('password', $password);
        }

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        if($input->getOption('admin')) {
            $roles[] = 'ROLE_ADMIN';
        }

        $user = new User();
        $hash = $this->passwordHasher->hashPassword($user, $password);
        
        $user
            ->setUsername($username)
            ->setPassword($hash)
            ->setRoles($roles)
        ;

        $this->em->persist($user); //save (ordre à doctrine)
        $this->em->flush(); //execute les ordres 

        $this->io->success('New user as join the party!');

        return Command::SUCCESS;
    }
}
