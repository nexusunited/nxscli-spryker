<?php


namespace Nexus\RabbitMq;


use Xervice\Core\Facade\AbstractFacade;

/**
 * @method \Nexus\RabbitMq\RabbitMqFactory getFactory()
 * @method \Nexus\RabbitMq\RabbitMqConfig getConfig()
 * @method \Nexus\RabbitMq\RabbitMqClient getClient()
 */
class RabbitMqFacade extends AbstractFacade
{
    /**
     * @param string $name
     * @param string $container
     *
     * @return string
     */
    public function createVHost(string $name, string $container): string
    {
        return $this->getFactory()->createVHostProcessor($container)->addVHost($name);
    }

    /**
     * @param string $username
     * @param string $password
     * @param array $tags
     * @param string $container
     *
     * @return string
     */
    public function createUser(string $username, string $password, array $tags, string $container): string
    {
        return $this->getFactory()->createUserProcessor($container)->createUser($username, $password, $tags);
    }

    /**
     * @param string $username
     * @param string $tag
     * @param string $container
     *
     * @return string
     */
    public function addTagToUser(string $username, string $tag, string $container): string
    {
        return $this->getFactory()->createUserProcessor($container)->addUserTag($username, $tag);
    }

    /**
     * @param string $vhost
     * @param string $user
     * @param string $permissions
     * @param string $container
     *
     * @return string
     */
    public function addUserToVhost(string $vhost, string $user, string $permissions, string $container)
    {
        return $this->getFactory()->createVHostProcessor($container)->addUserToVHost($vhost, $user, $permissions);
    }
}