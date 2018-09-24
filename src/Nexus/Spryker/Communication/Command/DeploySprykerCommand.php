<?php


namespace Nexus\Spryker\Communication\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Business\Model\Command\AbstractCommand;

/**
 * @method \Nexus\Spryker\Business\SprykerFacade getFacade()
 */
class DeploySprykerCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('spryker:deploy')
            ->setDescription('Deploy Spryker')
            ->addArgument('container', InputArgument::OPTIONAL, 'PHP Container', 'php');
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
            $output->isVerbose()
        );

        if ($output->isVerbose()) {
            $output->writeln($response);
        }
    }

}