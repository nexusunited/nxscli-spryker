<?php
declare(strict_types=1);


namespace Nexus\SprykerEnv;


use Xervice\Config\XerviceConfig;
use Xervice\Core\Business\Model\Config\AbstractConfig;

class SprykerEnvConfig extends AbstractConfig
{
    const ANSIBLE_PATH = 'ansible.path';

    /**
     * @return string
     */
    public function getAnsiblePath(): string
    {
        return $this->get(
            self::ANSIBLE_PATH,
            realpath(__DIR__ . '/Ansible')
        );
    }
}