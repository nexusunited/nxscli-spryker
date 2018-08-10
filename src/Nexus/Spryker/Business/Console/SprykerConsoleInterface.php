<?php

namespace Nexus\Spryker\Business\Console;

interface SprykerConsoleInterface
{
    /**
     * @param string $command
     * @param array $params
     *
     * @return string
     */
    public function console(string $command, ...$params): string;
}