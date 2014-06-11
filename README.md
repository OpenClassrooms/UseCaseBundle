UseCaseBundle
=============
[![Build Status](https://travis-ci.org/OpenClassrooms/UseCaseBundle.svg?branch=master)](https://travis-ci.org/OpenClassrooms/UseCaseBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5ac2e986-fda3-49d4-9529-4c1b9c7505b8/mini.png)](https://insight.sensiolabs.com/projects/5ac2e986-fda3-49d4-9529-4c1b9c7505b8)
[![Coverage Status](https://coveralls.io/repos/OpenClassrooms/UseCaseBundle/badge.png)](https://coveralls.io/r/OpenClassrooms/UseCaseBundle)

UseCaseBundle provides OpenClassrooms\UseCase Library in a Symfony2 context. 
UseCase Library provides facilities to manage technical code over a Use Case in a Clean / Hexagonal / Use Case Architecture.

- **Security access**
- **Cache management**
- **Transactional context**
- **Events**

The goal is to have only functional code on the Use Case and manage technical code in an elegant way using annotations.

For usage of UseCase Library, please see the UseCase Library [documentation](https://github.com/OpenClassrooms/UseCase/blob/master/README.md#usage).

## Installation
This bundle can be installed using composer:

```composer require openclassrooms/use-case-bundle```
or by adding the package to the composer.json file directly.

```json
{
    "require": {
        "openclassrooms/use-case-bundle": "*"
    }
}
```

After the package has been installed, add the bundle to the AppKernel.php file:

```php
// in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new OpenClassrooms\Bundle\OpenClassroomsUseCaseBundle(),
        // ...
);
```
If cache facilities are needed, add the OpenClassrooms\CacheBundle to the AppKernel.php file:

```php
// in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new OpenClassrooms\Bundle\CacheBundle\OpenClassroomsCacheBundle(),
        new OpenClassrooms\Bundle\UseCaseBundle\OpenClassroomsUseCaseBundle(),
        // ...
);
```

## Configuration
UseCaseBundle requires no initial configuration.

This is the default configuration:
```yaml
# app/config/config.yml
openclassrooms_use_case:
    security: security_context               
    # an implementation of SecurityContextInterface or OpenClassrooms\UseCase\Application\Services\Security\Security
    transaction: doctrine.orm.entity_manager
    # an implementation of EntityManagerInterface or OpenClassrooms\UseCase\Application\Services\Transaction\Transaction
    event_sender: event_dispatcher
    # an implementation of EventDispatcherInterface or OpenClassrooms\UseCase\Application\Services\Event\EventSender
    event_factory: openclassrooms.use_case.event_factory
    # an implementation of OpenClassrooms\UseCase\Application\Services\Event\EventFactory
```

If cache facilities are needed, CacheBundle configuration MUST be set. See [documentation](https://github.com/OpenClassrooms/CacheBundle/blob/master/README.md#configuration) for more details.

Furthermore, **only needed services are used**. It means, for example, if only security is used, the others services will never be called. **Even if the services of the default configuration exist or not.**

## Usage

For usage of UseCase Library, please see the UseCase Library [documentation](https://github.com/OpenClassrooms/UseCase/blob/master/README.md#usage).

Add the tag ```openclassrooms.use_case``` to the use case declaration to enable UseCase Library facilities.

```xml
<!-- Resources/config/services.xml -->
<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="a_project.a_use_case.class">AProject\BusinessRules\UseCases\AUseCase</parameter>
    </parameters>

    <services>
        <service id="a_project.a_use_case" class="a_project.a_use_case.class">
            <tag name="openclassrooms.use_case"/>
        </service>
    </services>
</container>
```

The different services used are those defined in the configuration file. 
For each tag and each facilities, a specific service can be set:

```xml
        <service id="a_project.a_use_case" class="a_project.a_use_case.class">
            <tag name="openclassrooms.use_case" 
                    security="a.different.security_context" 
                    cache="a.different.cache" 
                    transaction="a.different.entity_manager"
                    event-sender="a.different.event_dipsatcher"
                    event-factory="a.different.event_factory"/>
        </service>
```
- *security* parameter MUST be an implementation of SecurityContextInterface or OpenClassrooms\UseCase\Application\Services\Security\Security
- *cache* parameter MUST be an implementation of OpenClassrooms\Cache\Cache\Cache
- *transaction* parameter MUST be an implementation of EntityManagerInterface or OpenClassrooms\UseCase\Application\Services\Transaction\Transaction
- *event-sender* parameter MUST be an implementation of EventDispatcherInterface or OpenClassrooms\UseCase\Application\Services\Event\EventSender
- *event-factory* parameter MUST be an implementation of OpenClassrooms\UseCase\Application\Services\Event\EventFactory
