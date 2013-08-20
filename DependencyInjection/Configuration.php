<?php

namespace Mremi\DolistBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('mremi_dolist');

        $rootNode
            ->children()
                ->arrayNode('api')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->integerNode('account_id')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('authentication_key')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->validate()
                                ->ifTrue(function($v) { return !is_string($v); })
                                ->thenInvalid('Invalid authentication_key %s')
                            ->end()
                        ->end()
                    ->end()

                    ->append($this->getApiNode('authentication', 'http://api.dolist.net/v2/AuthenticationService.svc?wsdl'))

                    ->append($this->getApiNode('contact', 'http://api.dolist.net/v2/ContactManagementService.svc?wsdl'))
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Gets an API node
     *
     * @param string $name A node name
     * @param string $wsdl A WSDL URI
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getApiNode($name, $wsdl)
    {
        $treeBuilder = new TreeBuilder;
        $node = $treeBuilder->root($name);

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('wsdl')->cannotBeEmpty()->defaultValue($wsdl)->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('soap_version')->defaultValue(SOAP_1_1)->values(array(SOAP_1_1, SOAP_1_2))->end()
                        ->scalarNode('proxy_host')->end()
                        ->scalarNode('proxy_port')->end()
                        ->scalarNode('proxy_login')->end()
                        ->scalarNode('proxy_password')->end()
                        ->scalarNode('compression')->end()
                        ->scalarNode('encoding')->end()
                        ->booleanNode('trace')->defaultValue('%kernel.debug%')->end()
                        ->arrayNode('classmap')->end()
                        ->scalarNode('exceptions')->end()
                        ->scalarNode('connection_timeout')
                            ->defaultValue(2)
                            ->validate()
                                ->ifTrue(function($v) { return !is_numeric($v); })
                                ->thenInvalid('Invalid connection timeout %s')
                            ->end()
                        ->end()
                        ->scalarNode('typemap')->end()
                        ->scalarNode('cache_wsdl')->end()
                        ->scalarNode('user_agent')->end()
                        ->scalarNode('stream_context')->end()
                        ->scalarNode('features')->end()
                        ->scalarNode('keep_alive')->end()
                    ->end()
                ->end()
                ->scalarNode('retries')
                    ->defaultValue(1)
                    ->validate()
                        ->ifTrue(function($v) { return !is_numeric($v); })
                        ->thenInvalid('Invalid retries %s')
                    ->end()
                ->end()
            ->end();

        return $node;
    }
}
