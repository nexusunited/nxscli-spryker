<?php

namespace Nexus\Development;

use Xervice\Development\Command\GenerateAutoCompleteCommand;
use Xervice\Development\DevelopmentFacade as XerviceDevelopmentFacade;

class DevelopmentFacade extends XerviceDevelopmentFacade
{
    /**
     * @return array
     */
    public function getCommands() : array 
    {
        $commands = [];
        if (class_exists(GenerateAutoCompleteCommand::class)) {
            $commands[] = new GenerateAutoCompleteCommand();
        }
        
        return $commands;
    }
}