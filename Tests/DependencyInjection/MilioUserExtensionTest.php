<?php

namespace Milio\UserBundle\Tests\DependencyInjection;

use Milio\UserBundle\DependencyInjection\MilioUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Class MilioUserExtensionTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class MilioUserExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $configuration;

    /**
     * @test
     */
    public function it_has_the_required_parameters()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MilioUserExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter('Milio\UserBundle\Entity\ViewUserProfile', 'milio_user.view.user_profile_class');
        $this->assertParameter('Milio\UserBundle\Entity\ViewUserSecurity', 'milio_user.view.user_security_class');
        $this->assertParameter('Milio\User\Domain\Write\Model\UserSecurity', 'milio_user.write.user_security_class');
    }

    /**
     * @test
     */
    public function it_has_the_required_definitions_for_command_handler()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MilioUserExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertHasDefinition('milio_user.command_handler');
        $this->assertHasDefinition('milio_user.command_handler.default');
    }

    /**
     * @test
     */
    public function it_has_the_required_definitions_for_projectors()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MilioUserExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertHasDefinition('milio_user.projector.view_user_profile.default');
        $this->assertHasDefinition('milio_user.projector.view_user_profile');
        $this->assertHasDefinition('milio_user.projector.view_user_security.default');
        $this->assertHasDefinition('milio_user.projector.view_user_security');
    }


    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue($this->configuration->hasDefinition($id) || $this->configuration->hasAlias($id), sprintf('%s definition not found', $id));
    }

    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ? : $this->configuration->hasAlias($id)));
    }

    /**
     * Gets an empty config
     *
     * @return mixed
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF

EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
