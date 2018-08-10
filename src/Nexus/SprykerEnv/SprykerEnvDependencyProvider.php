<?php
declare(strict_types=1);


namespace Nexus\SprykerEnv;


use Nexus\SprykerEnv\Communication\BuildEnvCommand;
use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class SprykerEnvDependencyProvider extends AbstractProvider
{
    public const COMMAND_LIST = 'command.list';
    public const SHELL_FACADE = 'shell.facade';
    public const DOCKER_CLIENT_FACADE = 'docker.client.facade';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    public function handleDependencies(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::COMMAND_LIST] = function () {
            return $this->getCommandList();
        };

        $dependencyProvider[self::SHELL_FACADE] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->shell()->facade();
        };

        $dependencyProvider[self::DOCKER_CLIENT_FACADE] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->dockerClient()->facade();
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