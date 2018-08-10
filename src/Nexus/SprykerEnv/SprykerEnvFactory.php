<?php
declare(strict_types=1);


namespace Nexus\SprykerEnv;


use Nexus\SprykerEnv\Business\Example\StringPrinter;
use Nexus\SprykerEnv\Business\Example\StringPrinterInterface;
use Nexus\SprykerEnv\Business\SprykerServerSetup;
use Nexus\SprykerEnv\Business\SprykerServerSetupInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Factory\AbstractFactory;

/**
 * @method \Nexus\SprykerEnv\SprykerEnvConfig getConfig()
 */
class SprykerEnvFactory extends AbstractFactory
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \Nexus\SprykerEnv\Business\SprykerServerSetupInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createSprykerServerSetup(OutputInterface $output): SprykerServerSetupInterface
    {
        return new SprykerServerSetup(
            $this->getShellFacade(),
            $this->getDockerClientFacade(),
            $output,
            $this->getConfig()->getAnsiblePath()
        );
    }

    /**
     * @return array
     */
    public function getCommandList() : array
    {
        return $this->getDependency(SprykerEnvDependencyProvider::COMMAND_LIST);
    }

    /**
     * @return \Nexus\Shell\ShellFacade
     */
    public function getShellFacade()
    {
        return $this->getDependency(SprykerEnvDependencyProvider::SHELL_FACADE);
    }

    /**
     * @return \Nexus\DockerClient\DockerClientFacade
     */
    public function getDockerClientFacade()
    {
        return $this->getDependency(SprykerEnvDependencyProvider::DOCKER_CLIENT_FACADE);
    }
}