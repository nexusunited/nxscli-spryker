<?php


namespace Nexus\Spryker;


use Nexus\Spryker\Communication\Command\DeploySprykerCommand;
use Nexus\Spryker\Communication\Command\InstallSprykerCommand;
use Nexus\Spryker\Communication\Command\RabbitMqCommand;
use Nexus\Spryker\Communication\Command\SprykerConsoleCommand;
use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;

class SprykerDependencyProvider extends AbstractDependencyProvider
{
    public const DOCKER_FACADE = 'docker.facade';
    public const RABBITMQ_FACADE = 'rabbitmq.facade';
    public const SPRYKER_COMMANDS = 'spryker.commands';

    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::DOCKER_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->dockerClient()->facade();
        };

        $container[self::RABBITMQ_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->rabbitMq()->facade();
        };

        $container[self::SPRYKER_COMMANDS] = function () {
            return $this->getCommands();
        };

        return $container;
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