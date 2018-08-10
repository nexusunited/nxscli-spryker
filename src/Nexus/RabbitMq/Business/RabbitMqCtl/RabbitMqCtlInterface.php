<?php

namespace Nexus\RabbitMq\Business\RabbitMqCtl;

interface RabbitMqCtlInterface
{
    /**
     * @param string $command
     * @param mixed ...$params
     *
     * @return string
     */
    public function runCommand(string $command, ...$params): string;
}