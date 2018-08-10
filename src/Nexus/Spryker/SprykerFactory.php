<?php


namespace Nexus\Spryker;


use Nexus\DockerClient\DockerClientFacade;
use Nexus\Spryker\Communication\Business\Console\SprykerConsole;
use Nexus\Spryker\Communication\Business\Console\SprykerConsoleInterface;
use Nexus\Spryker\Communication\Business\Deploy\SprykerDeploy;
use Nexus\Spryker\Communication\Business\Installer\SprykerInstaller;
use Nexus\Spryker\Communication\Business\Installer\SprykerInstallerInterface;
use Xervice\Core\Factory\AbstractFactory;

/**
 * @method \Nexus\Spryker\SprykerConfig getConfig()
 */
class SprykerFactory extends AbstractFactory
{
    /**
     * @param string $container
     *
     * @return \Nexus\Spryker\Communication\Business\Deploy\SprykerDeploy
     */
    public function createSprykerDeploy(string $container): SprykerDeploy
    {
        return new SprykerDeploy(
            $this->createSprykerConsole($container)
        );
    }

    /**
     * @param string $container
     *
     * @return \Nexus\Spryker\Communication\Business\Console\SprykerConsoleInterface
     */
    public function createSprykerConsole(string $container): SprykerConsoleInterface
    {
        return new SprykerConsole(
            $this->getDockerFacade(),
            $container
        );
    }

    /**
     * @param string $container
     *
     * @return \Nexus\Spryker\Communication\Business\Installer\SprykerInstallerInterface
     */
    public function createprykerInstaller(string $container): SprykerInstallerInterface
    {
        return new SprykerInstaller(
            $this->getDockerFacade(),
            $container
        );
    }

    /**
     * @return \Nexus\DockerClient\DockerClientFacade
     */
    public function getDockerFacade(): DockerClientFacade
    {
        return $this->getDependency(SprykerDependencyProvider::DOCKER_FACADE);
    }

    /**
     * @return array
     */
    public function getCommandList(): array
    {
        return $this->getDependency(SprykerDependencyProvider::SPRYKER_COMMANDS);
    }
}