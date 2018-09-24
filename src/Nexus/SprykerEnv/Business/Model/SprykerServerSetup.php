<?php
declare(strict_types=1);


namespace Nexus\SprykerEnv\Business\Model;


use Nexus\DockerClient\Business\DockerClientFacadeInterface;
use Nexus\Shell\Business\ShellFacade;
use Symfony\Component\Console\Output\OutputInterface;

class SprykerServerSetup implements SprykerServerSetupInterface
{
    /**
     * @var ShellFacade
     */
    private $shellFacade;

    /**
     * @var \Nexus\DockerClient\Business\DockerClientFacadeInterface
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
     * @param \Nexus\DockerClient\Business\DockerClientFacadeInterface $dockerFacade
     * @param OutputInterface $output
     * @param string $ansiblePath
     */
    public function __construct(
        ShellFacade $shellFacade,
        DockerClientFacadeInterface $dockerFacade,
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
     * @param int $sshPort
     * @param int $webPort
     */
    public function createSprykerServer(string $name, int $sshPort, int $webPort): void
    {
        $this->startDockerServer($name, $sshPort, $webPort);
        $this->writeInventoryFile($sshPort);
        $this->enableSshKeyAccess($name);
        $this->copyAnsibleConfigToLocal();
        $this->installAnsibleDependencies();
        $this->installPythonToContainer($name);
        $this->runAnsible();
    }

    /**
     * @param string $name
     * @param int $port
     */
    private function startDockerServer(string $name, int $sshPort, int $webPort): void
    {
        $this->writeVerbose('Docker server will be started...');
        $command = sprintf(
            'run --name %s -d -p 0.0.0.0:%s:22 -p 0.0.0.0:%s:80 rastasheep/ubuntu-sshd:16.04',
            $name,
            $sshPort,
            $webPort
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
        $file = fopen($this->ansiblePath . '/inventory', 'w');
        fwrite($file, '[default]' . PHP_EOL);
        fwrite($file, '127.0.0.1:' . $port . PHP_EOL);
        fclose($file);
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
        $this->writeVerbose('Copy ansible config to ' . getcwd() . '...');
        $command = sprintf(
            'cp %s %s',
            $this->ansiblePath . '/ansible.cfg',
            getcwd() . '/ansible.cfg'
        );
        $this->writeVerbose(
            $this->shellFacade->runCommand($command)
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

    /**
     * @param string $name
     */
    private function installPythonToContainer(string $name): void
    {
        $command = sprintf(
            'exec -i %s bash -c "apt-get -y update && apt-get -y install python"',
            $name
        );
        $this->dockerFacade->runDocker($command);
    }
}