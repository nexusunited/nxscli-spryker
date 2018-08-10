<?php

namespace Nexus\RabbitMq\Business\User;

interface UserProcessorInterface
{
    /**
     * @param string $username
     * @param string $password
     * @param array $tags
     *
     * @return string
     */
    public function createUser(string $username, string $password, array $tags): string;

    /**
     * @param string $username
     * @param string $tag
     *
     * @return string
     */
    public function addUserTag(string $username, string $tag): string;
}