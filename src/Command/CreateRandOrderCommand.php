<?php


namespace App\Command;

use App\Service\OrderGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRandOrderCommand extends Command
{
    protected static $defaultName = 'app:create-order';

    private $entityManager;

    public function __construct(EntityManagerInterface  $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new random order for user.')
            ->setHelp('This command allows you to create a random order for user...')
            ->addArgument('count', InputArgument::OPTIONAL, 'The count generate orders(optional).')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cont = !empty($input->getArgument('count'))?(int)$input->getArgument('count'):10;

        try {
            $OrderGenerator = new OrderGenerator($this->entityManager);
            $orders = $OrderGenerator->generate($cont);

            foreach ($orders as $order){
                $this->entityManager->persist($order);
            }

            $this->entityManager->flush();

            $output->write('create a orders.');
        } catch (Exception $e) {
            $output->write($e);
        }
    }
}