<?php


namespace Nexus\RabbitMq\Business\RabbitMqCtl;


use Nexus\DockerClient\Business\DockerClientFacade;

class RabbitMqCtl implements RabbitMqCtlInterface
{
    /**
     * @var \Nexus\DockerClient\Business\DockerClientFacadeInterface
     */
    private $dockerFacade;

    /**
     * @var string
     */
    private $container;

    /**
     * RabbitMqCtl constructor.
     *
     * @param \Nexus\DockerClient\Business\DockerClientFacade $dockerFacade
     * @param string $container
     */
    public function __construct(DockerClientFacade $dockerFacade, string $container)
    {
        $this->dockerFacade = $dockerFacade;
        $this->container = $container;
    }

    /**
     * @param string $command
     * @param mixed ...$params
     *
     * @return string
     */
    public function runCommand(string $command, ...$params): string
    {
        $command = sprintf(
            'exec -i %s rabbitmqctl %s',
            $this->container,
            sprintf(
                $command,
                ...$params
            )
        );

        return $this->dockerFacade->runDocker($command);
    }
}