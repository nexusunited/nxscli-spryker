<?php

namespace Nexus\Spryker\Business\Installer;

interface SprykerInstallerInterface
{
    /**
     * @param string $suffix
     *
     * @return string
     */
    public function install(string $suffix): string;
}