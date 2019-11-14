<?php


namespace App\Command;

use App\Service\UserGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRandUserCommand extends Command
{

    protected static $defaultName = 'app:create-user';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new random user.')
            ->setHelp('This command allows you to create a random user...')
            ->addArgument('count', InputArgument::OPTIONAL, 'The count generate users(optional).')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cont = !empty($input->getArgument('count'))?(int)$input->getArgument('count'):10;

        $UserGenerator = new UserGenerator();

        try{
            $users = $UserGenerator->generate($cont);

            foreach ($users as $user){
                $this->entityManager->persist($user);
            }

            $this->entityManager->flush();

            $output->write('create a user.');
        }catch (Exception $exception){
            $output->write($exception);
        }
    }
}