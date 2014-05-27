<?php
/**
 * @copyright 2014 Instaclick Inc.
 */

namespace IC\Bundle\Base\HadoopBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Eldar Gafurov <eldarg@nationalfibre.net>
 */
class ICBaseHadoopExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        $loader        = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.xml');

        $this->initializeHadoop($config['hadoop'], $container);
    }

    /**
     * Initialize Hadoop configuration.
     *
     * @param array                                                   $config    Configuration
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container Container builder
     */
    private function initializeHadoop(array $config, ContainerBuilder $container)
    {
        $container->setParameter(
            'ic_base_hadoop.hdfs.host',
            $config['host']
        );

        $container->setParameter(
            'ic_base_hadoop.hdfs.port',
            $config['port']
        );

        $container->setParameter(
            'ic_base_hadoop.hdfs.path',
            $config['path']
        );
        $container->setParameter(
            'ic_base_hadoop.hdfs.username',
            $config['username']
        );
    }
}
