<?php

/*
 * This file is part of the Mremi\DolistBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\DolistBundle\Tests\DependencyInjection;

use Mremi\DolistBundle\DependencyInjection\MremiDolistExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Mremi Dolist extension test class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class MremiDolistExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $configuration;

    /**
     * Tests extension loading throws exception if api is not set
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "api" at path "mremi_dolist" must be configured.
     */
    public function testDolistLoadThrowsExceptionUnlessApiSet()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        unset($config['api']);
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if account identifier is not set
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "account_id" at path "mremi_dolist.api" must be configured.
     */
    public function testDolistLoadThrowsExceptionUnlessAccountIdSet()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        unset($config['api']['account_id']);
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if account identifier is empty
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.account_id". Expected int, but got string.
     */
    public function testDolistLoadThrowsExceptionIfAccountIdEmpty()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['account_id'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if account identifier is not numeric
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.account_id". Expected int, but got string.
     */
    public function testDolistLoadThrowsExceptionIfAccountIdNotNumeric()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['account_id'] = 'azerty';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication key is not set
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "authentication_key" at path "mremi_dolist.api" must be configured.
     */
    public function testDolistLoadThrowsExceptionUnlessAuthenticationKeySet()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        unset($config['api']['authentication_key']);
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication key is empty
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_dolist.api.authentication_key" cannot contain an empty value, but got "".
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationKeyEmpty()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication_key'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication key is not string
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid configuration for path "mremi_dolist.api.authentication_key": Invalid authentication_key 1234
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationKeyNotString()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication_key'] = 1234;
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication wsdl is empty
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_dolist.api.authentication.wsdl" cannot contain an empty value, but got "".
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationWsdlEmpty()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication']['wsdl'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication Soap version is invalid
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The value "foo" is not allowed for path "mremi_dolist.api.authentication.options.soap_version". Permissible values: 1, 2
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationSoapVersionInvalid()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication']['options']['soap_version'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication trace is not a boolean
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.authentication.options.trace". Expected boolean, but got string.
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationTraceNotBoolean()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication']['options']['trace'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication connection timeout is not numeric
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.authentication.options.connection_timeout". Expected int, but got string.
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationConnectionTimeoutNotNumeric()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication']['options']['connection_timeout'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if authentication retries is not numeric
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.authentication.retries". Expected int, but got string.
     */
    public function testDolistLoadThrowsExceptionIfAuthenticationRetriesNotNumeric()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['authentication']['retries'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if contact wsdl is empty
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "mremi_dolist.api.contact.wsdl" cannot contain an empty value, but got "".
     */
    public function testDolistLoadThrowsExceptionIfContactWsdlEmpty()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['contact']['wsdl'] = '';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if contact Soap version is invalid
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The value "foo" is not allowed for path "mremi_dolist.api.contact.options.soap_version". Permissible values: 1, 2
     */
    public function testDolistLoadThrowsExceptionIfContactSoapVersionInvalid()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['contact']['options']['soap_version'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if contact trace is not a boolean
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.contact.options.trace". Expected boolean, but got string.
     */
    public function testDolistLoadThrowsExceptionIfContactTraceNotBoolean()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['contact']['options']['trace'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if contact connection timeout is not numeric
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.contact.options.connection_timeout". Expected int, but got string.
     */
    public function testDolistLoadThrowsExceptionIfContactConnectionTimeoutNotNumeric()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['contact']['options']['connection_timeout'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests extension loading throws exception if contact retries is not numeric
     *
     * @expectedException        \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid type for path "mremi_dolist.api.contact.retries". Expected int, but got string.
     */
    public function testDolistLoadThrowsExceptionIfContactRetriesNotNumeric()
    {
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $config['api']['contact']['retries'] = 'foo';
        $loader->load(array($config), new ContainerBuilder);
    }

    /**
     * Tests services existence
     */
    public function testDolistLoadServicesWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('mremi_dolist.api.authentication_request');
        $this->assertHasDefinition('mremi_dolist.api.authentication_manager');
        $this->assertHasDefinition('mremi_dolist.api.contact_manager');
        $this->assertHasDefinition('mremi_dolist.api.field_manager');
    }

    /**
     * Cleanups the configuration
     */
    protected function tearDown()
    {
        $this->configuration = null;
    }

    /**
     * Creates an empty configuration
     */
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder;
        $loader = new MremiDolistExtension;
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * Creates a full configuration
     */
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder;
        $loader = new MremiDolistExtension;
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * Gets an empty config
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
api:
    account_id:         1234
    authentication_key: your_authentication_key
EOF;
        $parser = new Parser;

        return $parser->parse($yaml);
    }

    /**
     * Gets a full config
     *
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<EOF
api:
    account_id:         1234
    authentication_key: your_authentication_key

    # optional, default values are:
    authentication:
        wsdl:    http://api.dolist.net/v2/AuthenticationService.svc?wsdl
        options:
            soap_version:       1 # SOAP_1_1
            proxy_host:         ~
            proxy_port:         ~
            proxy_login:        ~
            proxy_password:     ~
            compression:        ~
            encoding:           ~
            trace:              %kernel.debug%
            classmap:           ~
            exceptions:         ~
            connection_timeout: 2
            typemap:            ~
            cache_wsdl:         ~
            user_agent:         ~
            stream_context:     ~
            features:           ~
            keep_alive:         ~
        retries: 1

    # optional, default values are:
    contact:
        wsdl:          http://api.dolist.net/v2/ContactManagementService.svc?wsdl
        options:
            soap_version:       1 # SOAP_1_1
            proxy_host:         ~
            proxy_port:         ~
            proxy_login:        ~
            proxy_password:     ~
            compression:        ~
            encoding:           ~
            trace:              %kernel.debug%
            classmap:           ~
            exceptions:         ~
            connection_timeout: 2
            typemap:            ~
            cache_wsdl:         ~
            user_agent:         ~
            stream_context:     ~
            features:           ~
            keep_alive:         ~
        retries: 1
EOF;
        $parser = new Parser;

        return $parser->parse($yaml);
    }

    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }
}
