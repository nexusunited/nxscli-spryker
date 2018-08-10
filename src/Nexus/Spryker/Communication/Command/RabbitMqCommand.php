<?php


namespace Nexus\Spryker\Communication\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Command\AbstractCommand;

/**
 * @method \Nexus\Spryker\SprykerFacade getFacade()
 */
class RabbitMqCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('spryker:rabbitmq:addstore')
            ->setDescription('Create Store in RabbitMQ')
            ->addArgument('container', InputArgument::OPTIONAL, 'PHP Container', 'rabbitmq')
            ->addArgument('store', InputArgument::OPTIONAL, 'Store to add (e.g. DE)', 'DE')
            ->addArgument('environment', InputArgument::OPTIONAL, 'Environment to add (e.g. development)', 'development')
            ->addArgument('password', InputArgument::OPTIONAL, 'User password', 'mate20mg');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
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