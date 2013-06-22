<?php

namespace Mremi\DolistBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MremiDolistExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('api.xml');

        $this->configureAuthenticationSoapClient($container, $config);
        $this->configureAuthenticationRequest($container, $config);
        $this->configureAuthenticationManager($container, $config);

        $this->configureContactSoapClient($container, $config);
        $this->configureContactManager($container, $config);
    }

    /**
     * Configures the authentication Soap client
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     */
    private function configureAuthenticationSoapClient(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('mremi_dolist.api.authentication.soap_client');
        $definition->replaceArgument(0, $config['api']['authentication']['wsdl']);
        $definition->replaceArgument(1, $config['api']['authentication']['options']);
    }

    /**
     * Configures the authentication request
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     */
    private function configureAuthenticationRequest(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('mremi_dolist.api.authentication_request');
        $definition->replaceArgument(0, $config['api']['account_id']);
        $definition->replaceArgument(1, $config['api']['authentication_key']);
    }

    /**
     * Configures the authentication manager
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     */
    private function configureAuthenticationManager(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('mremi_dolist.api.authentication_manager');
        $definition->replaceArgument(2, $config['api']['authentication']['retries']);
    }

    /**
     * Configures the contact Soap client
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     */
    private function configureContactSoapClient(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('mremi_dolist.api.contact.soap_client');
        $definition->replaceArgument(0, $config['api']['contact']['wsdl']);
        $definition->replaceArgument(1, $config['api']['contact']['options']);
    }

    /**
     * Configures the contact manager
     *
     * @param ContainerBuilder $container A container builder instance
     * @param array            $config    An array of configuration
     */
    private function configureContactManager(ContainerBuilder $container, array $config)
    {
        $definition = $container->getDefinition('mremi_dolist.api.contact_manager');
        $definition->replaceArgument(2, $config['api']['contact']['retries']);
    }
}
