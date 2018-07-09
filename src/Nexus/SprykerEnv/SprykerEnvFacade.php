<?php


namespace Nexus\SprykerEnv;


use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Facade\AbstractFacade;

/**
 * @method \Nexus\SprykerEnv\SprykerEnvFactory getFactory()
 * @method \Nexus\SprykerEnv\SprykerEnvConfig getConfig()
 */
class SprykerEnvFacade extends AbstractFacade
{
    /**
     * @param string $name
     * @param int $port
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createSprykerServer(string $name, int $port, OutputInterface $output)
    {
        $this->getFactory()->createSprykerServerSetup($output)->createSprykerServer($name, $port);
    }

    /**
     * @return array
     */
    public function getCommands() : array
    {
        return $this->getFactory()->getCommandList();
    }
}