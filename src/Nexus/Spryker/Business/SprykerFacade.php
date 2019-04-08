<?php
declare(strict_types=1);

namespace Nexus\Spryker\Business;

use Xervice\Core\Business\Model\Facade\AbstractFacade;

/**
 * @method \Nexus\Spryker\Business\SprykerBusinessFactory getFactory()
 */
class SprykerFacade extends AbstractFacade
{
    /**
     * @param string $container
     * @param string $suffix
     * @param string $roles
     *
     * @return string
     */
    public function installSpryker(string $container, string $suffix, string $roles): string
    {
        return $this->getFactory()->createprykerInstaller($container)->install($suffix, $roles);
    }

    /**
     * @param string $container
     * @param string $store
     * @param string $environment
     * @param string $password
     *
     * @return string
     */
    public function addSprykerStoreToRabbitMq(
        string $container,
        string $store,
        string $environment,
        string $password
    ): string {
        return $this->getFactory()->createRabbitMqPrepare($container)->addStoreToRabbitMq(
            $store,
            $environment,
            $password
        );
    }

    /**
     * @param string $container
     * @param bool $verbose
     *
     * @return string
     */
    public function deploySpryker(string $container, bool $verbose): string
    {
        return $this->getFactory()->createSprykerDeploy($container)->deploy($verbose);
    }

    /**
     * @param string $container
     * @param string $command
     * @param mixed ...$params
     *
     * @return string
     */
    public function runSprykerConsole(string $container, string $command, ...$params): string
    {
        return $this->getFactory()->createSprykerConsole($container)->console($command, ...$params);
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->getFactory()->getCommandList();
    }
}