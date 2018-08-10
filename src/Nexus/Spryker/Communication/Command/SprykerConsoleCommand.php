<?php


namespace Nexus\Spryker\Communication\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Command\AbstractCommand;

/**
 * @method \Nexus\Spryker\SprykerFacade getFacade()
 */
class SprykerConsoleCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('spryker:console')
            ->setDescription('Run Spryker console command')
            ->addArgument('command', InputArgument::REQUIRED, 'Command to run in spryker')
            ->addArgument('container', InputArgument::OPTIONAL, 'PHP Container', 'php');
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
        $response = $this->getFacade()->runSprykerConsole(
            $input->getArgument('container'),
            $input->getArgument('command')
        );

        if ($output->isVerbose()) {
            $output->writeln($response);
        }
    }

}