<?php


namespace Nexus\RabbitMq\Business\User;


use Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface;

class UserProcessor implements UserProcessorInterface
{
    /**
     * @var \Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface
     */
    private $rabbitMqCtl;

    /**
     * UserProcessor constructor.
     *
     * @param \Nexus\RabbitMq\Business\RabbitMqCtl\RabbitMqCtlInterface $rabbitMqCtl
     */
    public function __construct(RabbitMqCtlInterface $rabbitMqCtl)
    {
        $this->rabbitMqCtl = $rabbitMqCtl;
    }

    /**
     * @param string $username
     * @param string $password
     * @param array $tags
     *
     * @return string
     */
    public function createUser(string $username, string $password, array $tags): string
    {
        $response = '';

        $response .= $this->rabbitMqCtl->runCommand(
            sprintf(
                'add_user %s %s',
                $username,
                $password
            )
        );

        foreach ($tags as $tag) {
            $response .= $this->addUserTag($username, $tag);
        }

        return $response;
    }

    /**
     * @param string $username
     * @param string $tag
     *
     * @return string
     */
    public function addUserTag(string $username, string $tag): string
    {
        return  $this->rabbitMqCtl->runCommand(
            sprintf(
                'set_user_tags %s %s',
                $username,
                $tag
            )
        );
    }
}