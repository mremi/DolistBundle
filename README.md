MremiDolistBundle
=================

This bundle implements the Dolist library for Symfony2.

**Basic Docs**

* [Installation](#installation)
* [Add a contact](#add-contact)
* [Retrieve contacts](#retrieve-contacts)

<a name="installation"></a>

## Installation

### Step 1) Get the bundle and the library

First, grab the Dolist library and MremiDolistBundle. There are two different
ways to do this:

#### Method a) Using composer (symfony 2.1 pattern)

Add on composer.json (see http://getcomposer.org/)

    "require": {
        // ...
        "mremi/dolist-bundle": "dev-master"
    }

#### Method b) Using the `deps` file (symfony 2.0 pattern)

Add the following lines to your  `deps` file and then run `php bin/vendors
install`:

```
[Dolist]
    git=https://github.com/mremi/Dolist
    target=Mremi/Dolist

[DolistBundle]
    git=https://github.com/mremi/DolistBundle
    target=bundles/Mremi/Bundle/DolistBundle
```

#### Method c) Using submodules

Run the following commands to bring in the needed libraries as submodules.

```bash
git submodule add https://github.com/mremi/Dolist vendor/Mremi/Dolist
git submodule add https://github.com/mremi/DolistBundle vendor/bundles/Mremi/Bundle/DolistBundle
```

### Step 2) Register the namespaces

If you installed the bundle by composer, use the created autoload.php  (jump to step 3).
Add the following two namespace entries to the `registerNamespaces` call
in your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Mremi' => array(
        __DIR__.'/../vendor',
        __DIR__.'/../vendor/bundles',
    ),
    // ...
));
```

### Step 3) Register the bundle

To start using the bundle, register it in your Kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mremi\DolistBundle\MremiDolistBundle(),
    );
    // ...
}
```

### Step 4) Configure the bundle

The bundle comes with a sensible default configuration, which is listed below.
However you have to configure at least your account identifier and
authentication key.

```yaml
# app/config/config.yml
mremi_dolist:
    api:
        # mandatory
        account_id:         your_account_identifier
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
```

<a name="add-contact"></a>

## Add/update a contact

Two services allow you to add or update a contact, to use like this:

```php
<?php

$contactManager = $container->get('mremi_dolist.api.contact_manager');
$fieldManager = $container->get('mremi_dolist.api.field_manager');

$contact = $contactManager->create();
$contact->setEmail('test@example.com');
$contact->addField($fieldManager->create('firstname', 'Firstname'));
$contact->addField($fieldManager->create('lastname', 'Lastname'));

$ticket = $contactManager->save($contact);

$saved = $contactManager->getStatusByTicket($ticket);

if ($saved->isOk()) {
    // contact has been saved...
} else {
    // something is wrong...
    echo sprintf('Returned code: %s, description: %s', $saved->getReturnCode(), $saved->getDescription());
}
```

<a name="retrieve-contacts"></a>

## Retrieve contacts

```php
<?php

use Mremi\Dolist\Contact\GetContactRequest;

$contactManager = $container->get('mremi_dolist.api.contact_manager');

$request = new GetContactRequest;
$request->setOffset(50);
// ...

$contacts = $contactManager->getContacts($request);
