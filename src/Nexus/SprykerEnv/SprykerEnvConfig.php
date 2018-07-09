<?php


namespace Nexus\SprykerEnv;


use Xervice\Config\XerviceConfig;
use Xervice\Core\Config\AbstractConfig;
use Xervice\Core\CoreConfig;

class SprykerEnvConfig extends AbstractConfig
{
    const ANSIBLE_PATH = 'ansible.path';

    /**
     * @return string
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function getAnsiblePath(): string
    {
        return $this->get(
            self::ANSIBLE_PATH,
            realpath(__DIR__ . '/Ansible')
        );
    }
}