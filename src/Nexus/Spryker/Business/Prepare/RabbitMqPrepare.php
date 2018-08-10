<?php


namespace Nexus\Spryker\Business\Prepare;


use Nexus\RabbitMq\RabbitMqFacade;

class RabbitMqPrepare implements RabbitMqPrepareInterface
{
    /**
     * @var \Nexus\RabbitMq\RabbitMqFacade
     */
    private $rabbitMqFacade;

    /**
     * @var string
     */
    private $container;

    /**
     * RabbitMqPrepare constructor.
     *
     * @param \Nexus\RabbitMq\RabbitMqFacade $rabbitMqFacade
     * @param string $container
     */
    public function __construct(RabbitMqFacade $rabbitMqFacade, string $container)
    {
        $this->rabbitMqFacade = $rabbitMqFacade;
        $this->container = $container;
    }

    /**
     * @param string $store
     * @param string $environment
     * @param string $password
     *
     * @return string
     */
    public function addStoreToRabbitMq(string $store, string $environment, string $password): string
    {
        $username = sprintf(
            '%s_%s',
            $store,
            $environment
        );
        $vhost = sprintf(
            '/%s_%s_zed',
            $store,
            $environment
        );

        $response = '';
        $response .= $this->rabbitMqFacade->createVHost($vhost, $this->container);
        $response .= $this->rabbitMqFacade->createUser($username, $password, ['administrator'], $this->container);
        $response .= $this->rabbitMqFacade->addUserToVhost($vhost, $username, '".*" ".*" ".*"', $this->container);

        return $response;
    }
}