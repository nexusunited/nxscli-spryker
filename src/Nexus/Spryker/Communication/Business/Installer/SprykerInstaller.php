<?php


namespace Nexus\Spryker\Communication\Business\Installer;


use Nexus\DockerClient\DockerClientFacade;

class SprykerInstaller implements SprykerInstallerInterface
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
     * SprykerInstaller constructor.
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
     * @param string $suffix
     *
     * @return string
     */
    public function install(string $suffix): string
    {
        $command = sprintf(
            'exec -i %s php /data/shop/development/current/vendor/bin/install %s',
            $this->container,
            $suffix
        );

        return $this->dockerFacade->runDocker($command);
    }


}