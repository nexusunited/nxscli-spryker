<?php


namespace Nexus\RabbitMq\Business\RabbitMqCtl;


use Nexus\DockerClient\DockerClientFacade;

class RabbitMqCtl implements RabbitMqCtlInterface
{
    /**
     * @var \Nexus\DockerClient\DockerClientFacade
     */
    private $dockerFacade;

    /**
     * @var string
     */
    private $container;

    /**
     * RabbitMqCtl constructor.
     *
     * @param \Nexus\DockerClient\DockerClientFacade $dockerFacade
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