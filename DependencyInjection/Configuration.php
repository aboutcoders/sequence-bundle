<?php

namespace Abc\Bundle\SequenceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('abc_sequence');

        $supportedDrivers = array('orm', 'custom');
        $rootNode
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('model_manager_name')->defaultNull()->end()
            ->end();

        $this->addSequenceSection($rootNode);

        return $treeBuilder;
    }


    private function addSequenceSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('sequence')
            ->addDefaultsIfNotSet()
            ->canBeUnset()
            ->children()
                ->scalarNode('sequence_manager')->defaultValue('abc.sequence.sequence_manager.default')->end()
            ->end()
            ->end()
            ->end();
    }

}
