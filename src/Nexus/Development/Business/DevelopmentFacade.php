<?php
declare(strict_types=1);

namespace Nexus\Development\Business;


use Xervice\Development\Business\DevelopmentFacade as XerviceDevelopmentFacade;
use Xervice\Development\Communication\Console\Command\GenerateAutoCompleteCommand;

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