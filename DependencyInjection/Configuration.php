<?php

namespace Milio\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('milio_user');
        $rootNode
            ->children()
            ->arrayNode('model_class')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('view_user_profile')->defaultValue('Milio\UserBundle\Entity\ViewUserProfile')->cannotBeEmpty()->end()
                    ->scalarNode('view_user_security')->defaultValue('Milio\UserBundle\Entity\ViewUserSecurity')->cannotBeEmpty()->end()
                    ->scalarNode('write_user_security')->defaultValue('Milio\User\Domain\Write\Model\UserSecurity')->cannotBeEmpty()->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
