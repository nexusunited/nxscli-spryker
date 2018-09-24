<?php
declare(strict_types=1);


namespace Nexus\SprykerEnv\Business;


use Nexus\SprykerEnv\Business\Model\SprykerServerSetup;
use Nexus\SprykerEnv\Business\Model\SprykerServerSetupInterface;
use Nexus\SprykerEnv\SprykerEnvDependencyProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;

/**
 * @method \Nexus\SprykerEnv\SprykerEnvConfig getConfig()
 */
class SprykerEnvBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \Nexus\SprykerEnv\Business\Model\SprykerServerSetupInterface
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
     * @return \Nexus\Shell\Business\ShellFacadeInterface
     */
    public function getShellFacade()
    {
        return $this->getDependency(SprykerEnvDependencyProvider::SHELL_FACADE);
    }

    /**
     * @return \Nexus\DockerClient\Business\DockerClientFacadeInterface
     */
    public function getDockerClientFacade()
    {
        return $this->getDependency(SprykerEnvDependencyProvider::DOCKER_CLIENT_FACADE);
    }
}