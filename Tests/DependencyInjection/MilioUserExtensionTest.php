<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

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
    public function test_parameter()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new MilioUserExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);

        $this->assertParameter('read_class', 'milio_user.user_read_class');
        $this->assertParameter('write_class', 'milio_user.user_write_class');
        $this->assertHasDefinition('milia_user.service.security_password_service');
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
        $this->assertTrue(($this->configuration->hasDefinition($id) ? : $this->configuration->hasAlias($id)));
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
user_read_class: read_class
user_write_class: write_class
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
