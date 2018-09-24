<?php
declare(strict_types=1);


namespace Nexus\SprykerEnv;


use Nexus\SprykerEnv\Communication\BuildEnvCommand;
use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;

class SprykerEnvDependencyProvider extends AbstractDependencyProvider
{
    public const COMMAND_LIST = 'command.list';
    public const SHELL_FACADE = 'shell.facade';
    public const DOCKER_CLIENT_FACADE = 'docker.client.facade';

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::COMMAND_LIST] = function () {
            return $this->getCommandList();
        };

        $container[self::SHELL_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->shell()->facade();
        };

        $container[self::DOCKER_CLIENT_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->dockerClient()->facade();
        };

        return $container;
    }

    /**
     * @return array
     */
    protected function getCommandList()
    {
        return [
            new BuildEnvCommand()
        ];
    }
}