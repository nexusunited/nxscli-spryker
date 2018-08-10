<?php


namespace Nexus\RabbitMq;


use Nexus\DockerClient\DockerClientFacade;
use Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtl;
use Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface;
use Nexus\RabbitMq\Business\User\UserProcessor;
use Nexus\RabbitMq\Business\User\UserProcessorInterface;
use Nexus\RabbitMq\Business\VHost\VHostProcessor;
use Nexus\RabbitMq\Business\VHost\VHostProcessorInterface;
use Xervice\Core\Factory\AbstractFactory;

/**
 * @method \Nexus\RabbitMq\RabbitMqConfig getConfig()
 */
class RabbitMqFactory extends AbstractFactory
{
    /**
     * @param string $container
     *
     * @return \Nexus\RabbitMq\Business\User\UserProcessorInterface
     */
    public function createUserProcessor(string $container): UserProcessorInterface
    {
        return new UserProcessor(
            $this->createRabbitMqCtl($container)
        );
    }

    /**
     * @param string $container
     *
     * @return \Nexus\RabbitMq\Business\VHost\VHostProcessorInterface
     */
    public function createVHostProcessor(string $container): VHostProcessorInterface
    {
        return new VHostProcessor(
            $this->createRabbitMqCtl($container)
        );
    }

    /**
     * @param string $container
     *
     * @return \Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface
     */
    public function createRabbitMqCtl(string $container): RabbitMqCtlInterface
    {
        return new RabbitMqCtl(
            $this->getDockerFacade(),
            $container
        );
    }

    /**
     * @return \Nexus\DockerClient\DockerClientFacade
     */
    public function getDockerFacade(): DockerClientFacade
    {
        return $this->getDependency(RabbitMqDependencyProvider::DOCKER_FACADER);
    }
}