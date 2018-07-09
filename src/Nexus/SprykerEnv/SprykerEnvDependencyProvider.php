<?php


namespace Nexus\SprykerEnv;


use Nexus\SprykerEnv\Communication\BuildEnvCommand;
use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class SprykerEnvDependencyProvider extends AbstractProvider
{
    const COMMAND_LIST = 'command.list';

    const SHELL_FACADE = 'shell.facade';

    const DOCKER_CLIENT_FACADE = 'docker.client.facade';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $container
     */
    public function handleDependencies(DependencyProviderInterface $container)
    {
        $container[self::COMMAND_LIST] = function (DependencyProviderInterface $container) {
            return $this->getCommandList();
        };

        $container[self::SHELL_FACADE] = function (DependencyProviderInterface $container) {
            return $container->getLocator()->shell()->facade();
        };

        $container[self::DOCKER_CLIENT_FACADE] = function (DependencyProviderInterface $container) {
            return $container->getLocator()->dockerClient()->facade();
        };
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