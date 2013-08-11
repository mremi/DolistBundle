MremiDolistBundle
=================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/89c24e51-9896-4a9b-9419-788d2ca7b24a/big.png)](https://insight.sensiolabs.com/projects/89c24e51-9896-4a9b-9419-788d2ca7b24a)

[![Build Status](https://api.travis-ci.org/mremi/DolistBundle.png?branch=master)](https://travis-ci.org/mremi/DolistBundle)
[![Total Downloads](https://poser.pugx.org/mremi/dolist-bundle/downloads.png)](https://packagist.org/packages/mremi/dolist-bundle)
[![Latest Stable Version](https://poser.pugx.org/mremi/dolist-bundle/v/stable.png)](https://packagist.org/packages/mremi/dolist-bundle)

This bundle implements the [Dolist](https://github.com/mremi/Dolist) library for Symfony2.

## Prerequisites

This version of the bundle requires Symfony 2.1+.

**Basic Docs**

* [Installation](#installation)
* [Add a contact](#add-contact)
* [Retrieve contacts](#retrieve-contacts)

<a name="installation"></a>

## Installation

Installation is a quick 3 step process:

1. Download MremiDolistBundle using composer
2. Enable the Bundle
3. Configure the MremiDolistBundle

### Step 1: Download MremiDolistBundle using composer

Add MremiDolistBundle in your composer.json:

```js
{
    "require": {
        "mremi/dolist-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update mremi/dolist-bundle
```

Composer will install the bundle to your project's `vendor/mremi` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mremi\DolistBundle\MremiDolistBundle(),
    );
}
```

### Step 3: Configure the MremiDolistBundle

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
