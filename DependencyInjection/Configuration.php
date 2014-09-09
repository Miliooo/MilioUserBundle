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
            ->scalarNode('user_read_class')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('user_write_class')->isRequired()->cannotBeEmpty()->end()
        ->end();

        return $treeBuilder;
    }
}
