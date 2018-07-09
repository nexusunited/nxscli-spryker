<?php
namespace NexusTest\ExampleCommand;

use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Locator\Locator;

class FacadeTest extends \Codeception\Test\Unit
{
    /**
     * @var \Nexus\ExampleCommand\ExampleCommandFacade
     */
    protected $facade;
    
    protected function _before()
    {
        $this->facade = Locator::getInstance()->exampleCommand()->facade();
    }

    /**
     * @group Nexus
     * @group ExampleCommand
     * @group Facade
     * @group Integration
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function testExecuteExampleCommand()
    {
        $output = $this->getMockBuilder(Output::class)
            ->setMethods(['writeln', 'doWrite'])
            ->getMock();

        $output->expects($this->once())
            ->method('writeln')
            ->with($this->equalTo('Hello World!'))
            ->willReturn(null);

        $this->facade->executeExampleCommand($output);
    }
}