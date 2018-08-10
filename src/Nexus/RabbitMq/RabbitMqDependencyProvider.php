<?php


namespace Nexus\RabbitMq;


use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class RabbitMqDependencyProvider extends AbstractProvider
{
    public const DOCKER_FACADER = 'docker.facade';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    public function handleDependencies(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::DOCKER_FACADER] = function (DependencyProviderInterface $dependencyProvider) {
            return $dependencyProvider->getLocator()->dockerClient()->facade();
        };
    }
}