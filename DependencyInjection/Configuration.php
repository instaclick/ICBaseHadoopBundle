<?php

namespace IC\Bundle\Base\HadoopBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Eldar Gafurov <eldarg@nationalfibre.net>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('ic_base_hadoop');

        $this->configureHadoop($rootNode);

        return $treeBuilder;
    }

    /**
     * Configure hadoop information
     *
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function configureHadoop(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('hadoop')
                    ->children()
                        ->scalarNode('host')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('port')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('path')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
