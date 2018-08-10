<?php


namespace Nexus\Spryker\Business\Deploy;


use Nexus\Spryker\Business\Console\SprykerConsoleInterface;

class SprykerDeploy implements SprykerDeployInterface
{
    /**
     * @var \Nexus\Spryker\Business\Console\SprykerConsoleInterface
     */
    private $sprykerConsole;

    /**
     * SprykerDeploy constructor.
     *
     * @param \Nexus\Spryker\Business\Console\SprykerConsoleInterface $sprykerConsole
     */
    public function __construct(SprykerConsoleInterface $sprykerConsole)
    {
        $this->sprykerConsole = $sprykerConsole;
    }

    /**
     * @param bool $verbose
     *
     * @return string
     */
    public function deploy(bool $verbose): string
    {
        $suffix = $verbose ? '-vvv' : '';

        $response = '';
        $response .= $this->sprykerConsole->console('log:clear %s', $suffix);
        $response .= $this->sprykerConsole->console('cache:empty-all %s', $suffix);
        $response .= $this->sprykerConsole->console('setup:jenkins:disable %s', $suffix);
        $response .= $this->sprykerConsole->console('transfer:generate %s', $suffix);
        $response .= $this->sprykerConsole->console('twig:cache:warmer %s', $suffix);
        $response .= $this->sprykerConsole->console('navigation:build-cache %s', $suffix);
        $response .= $this->sprykerConsole->console('propel:migrate %s', $suffix);
        $response .= $this->sprykerConsole->console('data:import %s', $suffix);
        $response .= $this->sprykerConsole->console('transfer:generate %s', $suffix);
        $response .= $this->sprykerConsole->console('product-label:relations:update %s', $suffix);
        $response .= $this->sprykerConsole->console('setup:jenkins:generate %s', $suffix);
        $response .= $this->sprykerConsole->console('setup:jenkins:enable %s', $suffix);
        $response .= $this->sprykerConsole->console('frontend:project:install-dependencies %s', $suffix);
        $response .= $this->sprykerConsole->console('frontend:yves:install-dependencies %s', $suffix);
        $response .= $this->sprykerConsole->console('frontend:yves:build %s', $suffix);
        $response .= $this->sprykerConsole->console('frontend:zed:install-dependencies %s', $suffix);
        $response .= $this->sprykerConsole->console('frontend:zed:build %s', $suffix);

        return $response;
    }


}