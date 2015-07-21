<?php

namespace SMSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sms');

        $sms_api_key = (new ScalarNodeDefinition('sms_api_key'));
        $sms_api_secret = (new ScalarNodeDefinition('sms_api_secret'));
        $sms_api_enabled = (new BooleanNodeDefinition('enabled'));
        $rootNode
            ->children()
            ->append($sms_api_key->defaultNull()->info('SMS API Key'))
            ->append($sms_api_secret->defaultNull()->info('SMS API Secret'))
            ->append($sms_api_enabled->defaultFalse()->info('SMS API Enabled'))
            ->end()
        ;

        return $treeBuilder;
    }
}
