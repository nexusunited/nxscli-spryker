<?php


namespace Nexus\RabbitMq\Business;


use Nexus\DockerClient\Business\DockerClientFacade;
use Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtl;
use Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface;
use Nexus\RabbitMq\Business\User\UserProcessor;
use Nexus\RabbitMq\Business\User\UserProcessorInterface;
use Nexus\RabbitMq\Business\VHost\VHostProcessor;
use Nexus\RabbitMq\Business\VHost\VHostProcessorInterface;
use Nexus\RabbitMq\RabbitMqDependencyProvider;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;

class RabbitMqBusinessFactory extends AbstractBusinessFactory
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
     * @return \Nexus\DockerClient\Business\DockerClientFacade
     */
    public function getDockerFacade(): DockerClientFacade
    {
        return $this->getDependency(RabbitMqDependencyProvider::DOCKER_FACADER);
    }
}