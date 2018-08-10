<?php

namespace Nexus\Spryker\Communication\Business\Console;

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