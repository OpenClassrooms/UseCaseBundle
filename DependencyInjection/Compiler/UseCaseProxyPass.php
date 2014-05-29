<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\SecurityFactory;
use OpenClassrooms\Cache\Cache\Cache;
use OpenClassrooms\UseCase\Application\Services\Event\Event;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\UseCase\Application\Services\Security\Security;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyPass implements CompilerPassInterface
{
    private $reader;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $this->initContainer($container);
        $this->initReader();
        $this->initBuilder();
        $this->buildUseCaseProxies();
    }

    private function initContainer(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    private function initReader()
    {
        if ($this->container->hasDefinition('annotation_reader')) {
            $this->reader = $this->container->get('annotation_reader');
        } else {
            $this->reader = new AnnotationReader();
        }
    }

    private function initBuilder()
    {
        $this->builder = $this->container->get(
            'openclassrooms.use_case.use_case_proxy_builder'
        );
    }

    private function buildUseCaseProxies()
    {
        $taggedServices = $this->container->findTaggedServiceIds('openclassrooms.use_case');
        foreach ($taggedServices as $taggedServiceName => $parameters) {
            $parameters = $parameters[0];
            $this->buildUseCaseProxy($taggedServiceName, $parameters);
        }
    }

    private function buildUseCaseProxy($taggedServiceName, $parameters)
    {
        /** @var UseCase $useCase */
        $useCase = $this->container->get($taggedServiceName);
        /** @var UseCaseProxyBuilder $builder */
        $this->builder
            ->create($useCase)
            ->withReader($this->reader)
            ->withSecurity($this->buildSecurity($parameters))
            ->withCache($this->buildCache($parameters))
            ->withTransaction($this->buildTransaction($parameters))
            ->withEvent($this->buildEvent($parameters))
            ->withEventFactory($this->buildEventFactory($parameters));
        $this->container->set($taggedServiceName, $this->builder->build());
    }

    /**
     * @return Security
     */
    private function buildSecurity(array $parameters)
    {
        $security = null;
        if (isset($parameters['security'])) {
            $security = $this->container->get($parameters['security']);
            if ($security instanceof SecurityContextInterface) {
                /** @var SecurityFactory $securityFactory */
                $securityFactory = $this->container->get(
                    'openclassrooms.use_case.security_factory'
                );
                $security = $securityFactory->createSecurityContextSecurity($security);
            }
        }

        return $security;
    }

    /**
     * @return Cache
     */
    private function buildCache(array $parameters)
    {
        $cache = null;
        if (isset ($parameters['cache'])) {
            /** @var Cache $cache */
            $cache = $this->container->get($parameters['cache']);
        }

        return $cache;
    }

    /**
     * @return Transaction
     */
    private function buildTransaction(array $parameters)
    {
        $transaction = null;
        if (isset($parameters['transaction'])) {
            $transaction = $this->container->get($parameters['transaction']);
            if ($transaction instanceof EntityManagerInterface) {
                $transactionAdapterFactory = $this->container->get(
                    'openclassrooms.use_case.transaction_factory'
                );
                $transaction = $transactionAdapterFactory->createEntityManagerTransaction(
                    $transaction
                );
            }
        }

        return $transaction;
    }

    /**
     * @return Event
     */
    private function buildEvent(array $parameters)
    {
        $event = null;
        if (isset($parameters['event'])) {
            $event = $this->container->get($parameters['event']);
            if ($event instanceof EventDispatcherInterface) {
                $eventAdapterFactory = $this->container->get(
                    'openclassrooms.use_case.event_adapter_factory'
                );
                $event = $eventAdapterFactory->createEventDispatcherEvent($event);
            }
        }

        return $event;
    }

    /**
     * @return EventFactory
     */
    private function buildEventFactory(array $parameters)
    {
        $eventFactory = null;
        if (isset($parameters['event-factory'])) {
            $eventFactory = $this->container->get($parameters['event-factory']);
        }

        return $eventFactory;
    }
}
