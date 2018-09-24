<?php


namespace Nexus\Spryker\Business\Console;


use Nexus\DockerClient\Business\DockerClientFacade;

class SprykerConsole implements SprykerConsoleInterface
{
    /**
     * @var \Nexus\DockerClient\Business\DockerClientFacade
     */
    private $dockerFacade;

    /**
     * @var string
     */
    private $container;

    /**
     * SprykerConsole constructor.
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
     * @param array $params
     *
     * @return string
     */
    public function console(string $command, ...$params): string
    {
        $command = sprintf(
            'exec -i %s php /data/shop/development/current/vendor/bin/console %s',
            $this->container,
            sprintf(
                $command,
                ...$params
            )
        );

        return $this->dockerFacade->runDocker($command);
    }

}