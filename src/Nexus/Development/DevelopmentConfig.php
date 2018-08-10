<?php
declare(strict_types=1);


namespace Nexus\Development;


use Xervice\Development\DevelopmentConfig as XerviceDevelopmentConfig;

class DevelopmentConfig extends XerviceDevelopmentConfig
{
    public function getDirectories()
    {
        $dirs = parent::getDirectories();

        $dirs[] = $this->getApplicationPath() . '/vendor/nexusnetsoftgmbh/*/src/Nexus';

        return $dirs;
    }

}