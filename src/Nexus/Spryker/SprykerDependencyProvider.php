<?php


namespace Nexus\Spryker;


use Nexus\Spryker\Communication\Command\DeploySprykerCommand;
use Nexus\Spryker\Communication\Command\InstallSprykerCommand;
use Nexus\Spryker\Communication\Command\RabbitMqCommand;
use Nexus\Spryker\Communication\Command\SprykerConsoleCommand;
use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class SprykerDependencyProvider extends AbstractProvider
{
    public const DOCKER_FACADE = 'docker.facade';
    public const RABBITMQ_FACADE = 'rabbitmq.facade';
    public const SPRYKER_COMMANDS = 'spryker.commands';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    public function handleDependencies(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::DOCKER_FACADE] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->dockerClient()->facade();
        };

        $dependencyProvider[self::RABBITMQ_FACADE] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->rabbitMq()->facade();
        };

        $dependencyProvider[self::SPRYKER_COMMANDS] = function () {
            return $this->getCommands();
        };
    }

    /**
     * @return array
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    protected function getCommands(): array
    {
        return [
            new InstallSprykerCommand(),
            new SprykerConsoleCommand(),
            new DeploySprykerCommand(),
            new RabbitMqCommand()
        ];
    }
}