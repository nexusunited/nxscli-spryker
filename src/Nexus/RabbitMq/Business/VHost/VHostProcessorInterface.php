<?php

namespace Nexus\RabbitMq\Business\VHost;

interface VHostProcessorInterface
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function addVHost(string $name): string;

    /**
     * @param string $vhost
     * @param string $username
     * @param string $permissions
     *
     * @return string
     */
    public function addUserToVHost(string $vhost, string $username, string $permissions): string;
}