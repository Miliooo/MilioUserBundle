<?php

namespace Milio\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class Configuration
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('milio_user');

        return $treeBuilder;
    }
}
