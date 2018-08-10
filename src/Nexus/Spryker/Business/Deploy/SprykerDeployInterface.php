<?php

namespace Nexus\Spryker\Business\Deploy;

interface SprykerDeployInterface
{
    /**
     * @param bool $verbose
     *
     * @return string
     */
    public function deploy(bool $verbose): string;
}