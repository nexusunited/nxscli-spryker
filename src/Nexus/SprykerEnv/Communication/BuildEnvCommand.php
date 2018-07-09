<?php


namespace Nexus\SprykerEnv\Communication;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Command\AbstractCommand;

/**
 * @method \Nexus\SprykerEnv\SprykerEnvFacade getFacade()
 */
class BuildEnvCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('spryker:env:server')
            ->setDescription('Create a spryker ready ubuntu server')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the new instance')
            ->addArgument('port', InputArgument::OPTIONAL, 'SSH Port for the new instance', '22022');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->createSprykerServer(
            $input->getArgument('name'),
            (int)$input->getArgument('port'),
            $output
        );
    }

}