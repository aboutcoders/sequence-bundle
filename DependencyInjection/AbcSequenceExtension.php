<?php

namespace Abc\Bundle\SequenceBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class AbcSequenceExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/services'));

        if ('custom' !== $config['db_driver']) {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        }

        $this->remapParametersNamespaces($config, $container, array(
            '' => array(
                'model_manager_name' => 'abc.sequence.model_manager_name'
            )
        ));

        if (!empty($config['sequence'])) {
            $this->loadSequence($config['sequence'], $container, $loader, $config['db_driver']);
        }
    }

    private function loadSequence(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {
        if ('custom' !== $dbDriver) {
            $loader->load(sprintf('%s_sequence.xml', $dbDriver));
        }

        $container->setAlias('abc.sequence.sequence_manager', $config['sequence_manager']);

        $this->remapParametersNamespaces($config, $container, array(
            '' => array(
                'sequence_class' => 'abc.sequence.model.sequence.class',
            )
        ));

        $loader->load('services.xml');
    }

    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
} 