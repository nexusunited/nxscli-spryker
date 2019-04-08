<?php


namespace Nexus\Spryker\Communication\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Business\Model\Command\AbstractCommand;

/**
 * @method \Nexus\Spryker\Business\SprykerFacade getFacade()
 */
class InstallSprykerCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('spryker:install')
            ->setDescription('Install Spryker')
            ->addArgument('suffix', InputArgument::OPTIONAL, 'Stores to install', '')
            ->addArgument('container', InputArgument::OPTIONAL, 'PHP Container', 'php')
            ->addArgument('roles', InputArgument::OPTIONAL, 'Roles', 'development');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->getFacade()->installSpryker(
            $input->getArgument('container'),
            $input->getArgument('suffix'),
            $input->getArgument('roles')
        );

        if ($output->isVerbose()) {
            $output->writeln($response);
        }
    }

}