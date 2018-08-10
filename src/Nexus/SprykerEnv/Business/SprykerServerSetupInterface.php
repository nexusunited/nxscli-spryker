<?php
declare(strict_types=1);

namespace Nexus\SprykerEnv\Business;

interface SprykerServerSetupInterface
{
    /**
     * @param string $name
     * @param int $sshPort
     * @param int $webPort
     */
    public function createSprykerServer(string $name, int $sshPort, int $webPort): void;
}