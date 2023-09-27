<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create_user',
    description: 'Creates a new user account',
)]
class CreateUserCommand extends Command
{/* this command class was created using symfony console make:command and then app:create_user
    Then the config part was modified. lesson 57 . We added the constructor below to inject the password hasher and the user repository*/
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $users
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User e-mail')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description') //We did not need any option for the moment but we needed two arguments
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email'); //We passed the manually inserted email and password arguments below
        $password = $input->getArgument('password');

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );
        $this->users->save($user, true);

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // } // We did not need any note nor option

        $io->success(sprintf('User account %s was created!', $email));

        return Command::SUCCESS;
    }
}
