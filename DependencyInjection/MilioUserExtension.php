<?php

namespace Milio\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;

/**
 * This configures the bundle.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class MilioUserExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('command_handlers.xml');
        $loader->load('controller.xml');
        $loader->load('form.xml');
        $loader->load('listener.xml');
        $loader->load('provider.xml');

        $container->setParameter('milio_user.user_read_class', $config['user_read_class']);
        $container->setParameter('milio_user.user_write_class', $config['user_write_class']);
    }
}
