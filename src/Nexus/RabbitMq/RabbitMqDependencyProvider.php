<?php
declare(strict_types=1);

namespace Nexus\RabbitMq;


use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;

class RabbitMqDependencyProvider extends AbstractDependencyProvider
{
    public const DOCKER_FACADER = 'docker.facade';

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::DOCKER_FACADER] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->dockerClient()->facade();
        };

        return $container;
    }
}