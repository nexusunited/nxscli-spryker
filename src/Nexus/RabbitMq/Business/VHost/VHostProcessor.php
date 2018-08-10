<?php


namespace Nexus\RabbitMq\Business\VHost;


use Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface;

class VHostProcessor implements VHostProcessorInterface
{
    /**
     * @var \Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface
     */
    private $rabbitMqCtl;

    /**
     * VHostProcessor constructor.
     *
     * @param \Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface $rabbitMqCtl
     */
    public function __construct(RabbitMqCtlInterface $rabbitMqCtl)
    {
        $this->rabbitMqCtl = $rabbitMqCtl;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function addVHost(string $name): string
    {
        return $this->rabbitMqCtl->runCommand(
            sprintf(
                'add_vhost %s',
                $name
            )
        );
    }

    /**
     * @param string $vhost
     * @param string $username
     * @param string $permissions
     *
     * @return string
     */
    public function addUserToVHost(string $vhost, string $username, string $permissions): string
    {
        return $this->rabbitMqCtl->runCommand(
            sprintf(
                'set_permissions -p %s %s %s',
                $vhost,
                $username,
                $permissions
            )
        );
    }
}