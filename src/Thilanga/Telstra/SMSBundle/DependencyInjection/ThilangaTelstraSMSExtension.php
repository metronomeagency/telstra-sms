<?php

namespace Thilanga\Telstra\SMSBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ThilangaTelstraSMSExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        if (isset($config['enabled']) && $config['enabled']) {

            $container->setParameter('thilanga_telstra_sms.sms_api_key', $config['sms_api_key']);
            $container->setParameter('thilanga_telstra_sms.sms_api_secret', $config['sms_api_secret']);

            $loader->load('services.yml');
        }
    }
}
