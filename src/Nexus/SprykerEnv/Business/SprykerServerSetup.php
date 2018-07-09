<?php


namespace Nexus\SprykerEnv\Business;


use Nexus\DockerClient\DockerClientFacade;
use Nexus\Shell\ShellFacade;
use Symfony\Component\Console\Output\OutputInterface;

class SprykerServerSetup
{
    /**
     * @var ShellFacade
     */
    private $shellFacade;

    /**
     * @var \Nexus\DockerClient\DockerClientFacade
     */
    private $dockerFacade;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string
     */
    private $ansiblePath;

    /**
     * SprykerServerSetup constructor.
     *
     * @param ShellFacade $shellFacade
     * @param \Nexus\DockerClient\DockerClientFacade $dockerFacade
     * @param OutputInterface $output
     * @param string $ansiblePath
     */
    public function __construct(
        ShellFacade $shellFacade,
        DockerClientFacade $dockerFacade,
        OutputInterface $output,
        string $ansiblePath
    ) {
        $this->shellFacade = $shellFacade;
        $this->dockerFacade = $dockerFacade;
        $this->output = $output;
        $this->ansiblePath = $ansiblePath;
    }

    /**
     * @param string $name
     * @param int $port
     */
    public function createSprykerServer(string $name, int $port)
    {
        $this->startDockerServer($name, $port);
        $this->writeInventoryFile($port);
        $this->enableSshKeyAccess($name);
        $this->copyAnsibleConfigToLocal();
        $this->installAnsibleDependencies();
        $this->runAnsible();
    }

    /**
     * @param string $name
     * @param int $port
     */
    private function startDockerServer(string $name, int $port): void
    {
        $this->writeVerbose('Docker server will be started...');
        $command = sprintf(
            'run --name %s -d -p 0.0.0.0:%s:22 rastasheep/ubuntu-sshd:16.04',
            $name,
            $port
        );

        $this->dockerFacade->runDocker($command);
        $this->writeVerbose('Docker server is running');
    }

    /**
     * @param string $message
     */
    private function writeVerbose(string $message): void
    {
        if ($this->output->isVerbose()) {
            $this->output->writeln('[SPRYKER] ' . $message);
        }
    }

    /**
     * @param int $port
     */
    private function writeInventoryFile(int $port): void
    {
        $this->writeVerbose('Writing inventory');
        $fp = fopen($this->ansiblePath . '/inventory', 'w');
        fwrite($fp, '[default]' . PHP_EOL);
        fwrite($fp, '127.0.0.1:' . $port . PHP_EOL);
        fclose($fp);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function enableSshKeyAccess(string $name): void
    {
        $this->writeVerbose('Enable ssh key...');
        $command = sprintf(
            'exec %s passwd -d root',
            $name
        );
        $this->dockerFacade->runDocker($command);

        $command = sprintf(
            'cp %s %s:/root/.ssh/authorized_keys',
            $this->ansiblePath . '/key/authorized_keys',
            $name
        );
        $this->dockerFacade->runDocker($command);

        $command = sprintf(
            'exec %s chown root:root /root/.ssh/authorized_keys',
            $name
        );
        $this->dockerFacade->runDocker($command);
    }

    private function runAnsible(): void
    {
        $this->writeVerbose('Run ansible...');
        $command = sprintf(
            'ansible-playbook --key-file %s -i %s %s',
            $this->ansiblePath . '/key/id_rsa',
            $this->ansiblePath . '/inventory',
            $this->ansiblePath . '/environment/spryker_env.yaml'
        );
        $this->writeVerbose(
            $this->shellFacade->runCommand($command)
        );
    }

    private function copyAnsibleConfigToLocal(): void
    {
        $this->writeVerbose('Copy ansible config...');
        $command = sprintf(
            'cp %s %s',
            $this->ansiblePath . '/ansible.cfg',
            getcwd()
        );
    }

    private function installAnsibleDependencies(): void
    {
        $this->writeVerbose('Install ansible dependencies...');
        $command = sprintf(
            'ansible-galaxy install -r %s',
            $this->ansiblePath . '/environment/dependencies/requirements.yml'
        );
        $this->writeVerbose(
            $this->shellFacade->runCommand($command)
        );
    }
}