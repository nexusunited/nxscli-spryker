<?php

namespace Nexus\Spryker\Business\Installer;

interface SprykerInstallerInterface
{
    /**
     * @param string $suffix
     * @param string $roles
     *
     * @return string
     */
    public function install(string $suffix, string $roles): string;
}