<?php

namespace Nexus\Spryker\Business\Prepare;

interface RabbitMqPrepareInterface
{
    /**
     * @param string $store
     * @param string $environment
     * @param string $password
     *
     * @return string
     */
    public function addStoreToRabbitMq(string $store, string $environment, string $password): string;
}