<?php


namespace Nexus\Spryker\Communication\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Business\Model\Command\AbstractCommand;

/**
 * @method \Nexus\Spryker\Business\SprykerFacade getFacade()
 */
class RabbitMqCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('spryker:rabbitmq:addstore')
            ->setDescription('Create Store in RabbitMQ')
            ->addArgument('store', InputArgument::OPTIONAL, 'Store to add (e.g. DE)', 'DE')
            ->addArgument(
                'environment', InputArgument::OPTIONAL, 'Environment to add (e.g. development)', 'development'
            )
            ->addArgument('password', InputArgument::OPTIONAL, 'User password', 'mate20mg')
            ->addArgument('container', InputArgument::OPTIONAL, 'PHP Container', 'rabbitmq');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->getFacade()->addSprykerStoreToRabbitMq(
            $input->getArgument('container'),
            $input->getArgument('store'),
            $input->getArgument('environment'),
            $input->getArgument('password')
        );

        if ($output->isVerbose()) {
            $output->writeln($response);
        }
    }
}