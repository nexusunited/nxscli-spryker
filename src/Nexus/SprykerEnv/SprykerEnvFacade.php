<?php
declare(strict_types=1);


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
     * @param int $sshPort
     * @param int $webPort
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createSprykerServer(string $name, int $sshPort, int $webPort, OutputInterface $output): void
    {
        $this->getFactory()->createSprykerServerSetup($output)->createSprykerServer($name, $sshPort, $webPort);
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->getFactory()->getCommandList();
    }
}