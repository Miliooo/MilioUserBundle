<?php

namespace Milio\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

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
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('command_handlers.xml');
        $loader->load('controller.xml');
        $loader->load('listener.xml');
        $loader->load('provider.xml');
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('milio_user.view.user_profile_class', $config['model_class']['view_user_profile']);
        $container->setParameter('milio_user.view.user_security_class', $config['model_class']['view_user_security']);
        $container->setParameter('milio_user.write.user_security_class', $config['model_class']['write_user_security']);
    }
}
