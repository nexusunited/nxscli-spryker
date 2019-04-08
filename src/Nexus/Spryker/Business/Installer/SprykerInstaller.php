<?php


namespace Nexus\Spryker\Business\Installer;


use Nexus\DockerClient\Business\DockerClientFacade;

class SprykerInstaller implements SprykerInstallerInterface
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
     * SprykerInstaller constructor.
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
     * @param string $suffix
     * @param string $roles
     *
     * @return string
     */
    public function install(string $suffix, string $roles): string
    {
        $response = '';

        $response .= $this->dockerFacade->runDocker(
            $this->getComposerInstall()
        );
        $response .= $this->dockerFacade->runDocker(
            $this->getInstallCommand($suffix, $roles)
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
     * @param string $roles
     *
     * @return string
     */
    private function getInstallCommand(string $suffix, string $roles): string
    {
        $command = sprintf(
            'exec -i %s php /data/shop/development/current/vendor/bin/install -r %s %s',
            $this->container,
            $roles,
            $suffix
        );
        return $command;
    }


}