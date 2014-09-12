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
            ->scalarNode('command_handler')->defaultValue('milio_user.command_handler.default')->cannotBeEmpty()->end()
            ->arrayNode('projector')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('view_user_profile')->defaultValue('milio_user.projector.view_user_profile.default')->cannotBeEmpty()->end()
                    ->scalarNode('view_user_security')->defaultValue('milio_user.projector.view_user_security.default')->cannotBeEmpty()->end()
                ->end()
            ->end()
            ->arrayNode('view_model')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('view_user_profile')->defaultValue('Milio\UserBundle\Entity\ViewUserProfile')->cannotBeEmpty()->end()
                    ->scalarNode('view_user_security')->defaultValue('Milio\UserBundle\Entity\ViewUserSecurity')->cannotBeEmpty()->end()
                ->end()
            ->end()
            ->arrayNode('write_model')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('write_user_security')->defaultValue('Milio\User\Domain\Write\Model\UserSecurity')->cannotBeEmpty()->end()
                ->end()
        ->end();

        return $treeBuilder;
    }
}
