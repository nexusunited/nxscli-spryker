<?php


namespace Nexus\Spryker\Business\Installer;


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
        $response = '';

        $response .= $this->dockerFacade->runDocker(
            $this->getComposerInstall()
        );
        $response .= $this->dockerFacade->runDocker(
            $this->getInstallCommand($suffix)
        );

        return $response;
    }

    /**
     * @param string $suffix
     *
     * @return string
     */
    private function getComposerInstall(): string
    {
        $command = sprintf(
            'exec -i %s bash -c "cd /data/shop/development/current && composer install"',
            $this->container
        );
        return $command;
    }

    /**
     * @param string $suffix
     *
     * @return string
     */
    private function getInstallCommand(string $suffix): string
    {
        $command = sprintf(
            'exec -i %s php /data/shop/development/current/vendor/bin/install %s',
            $this->container,
            $suffix
        );
        return $command;
    }


}