<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Persistence\ObjectManager;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\SecurityFactory;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\TransactionFactory;
use OpenClassrooms\Cache\Cache\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException;
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
    /**
     * @var Reader
     */
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
        $this->builder = $this->container->get('openclassrooms.use_case.use_case_proxy_builder');
    }

    private function buildUseCaseProxies()
    {
        $taggedServices = $this->container->findTaggedServiceIds('openclassrooms.use_case');
        foreach ($taggedServices as $taggedServiceName => $tagParameters) {
            $tagParameters = $tagParameters[0];
            $this->buildUseCaseProxy($taggedServiceName, $tagParameters);
        }
    }

    private function buildUseCaseProxy($taggedServiceName, $tagParameters)
    {
        try {
            /** @var UseCase $useCase */
            $useCase = $this->container->get($taggedServiceName);
            $methodAnnotations = $this->reader->getMethodAnnotations(new \ReflectionMethod($useCase, 'execute'));

            /** @var UseCaseProxyBuilder $builder */
            $this->builder
                ->create($useCase)
                ->withReader($this->reader);

            foreach ($methodAnnotations as $annotation) {
                if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Security) {
                    $this->builder->withSecurity($this->buildSecurity($tagParameters));
                }
                if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Cache) {
                    $this->builder->withCache($this->buildCache($tagParameters));
                }
                if ($annotation instanceof \OpenClassrooms\UseCase\Application\Annotations\Transaction) {
                    $this->builder->withTransaction($this->buildTransaction($tagParameters));
                }
                if ($annotation instanceof Event) {
                    $this->builder
                        ->withEvent($this->buildEvent($tagParameters))
                        ->withEventFactory($this->buildEventFactory($tagParameters));
                }
            }
            $this->container->set($taggedServiceName, $this->builder->build());
        } catch (SecurityIsNotDefinedException $sinde) {
            throw new SecurityIsNotDefinedException(
                'Security should be defined for use case: '
                . $taggedServiceName . '. '
                . $sinde->getMessage());
        } catch (CacheIsNotDefinedException $cinde) {
            throw new CacheIsNotDefinedException('Cache should be defined for use case: '
                . $taggedServiceName . '. '
                . $cinde->getMessage());
        } catch (TransactionIsNotDefinedException $tinde) {
            throw new TransactionIsNotDefinedException('Transaction should be defined for use case: '
                . $taggedServiceName . '. '
                . $tinde->getMessage());
        } catch (EventIsNotDefinedException $einde) {
            throw new EventIsNotDefinedException('EventSender should be defined for use case: '
                . $taggedServiceName . '. '
                . $einde->getMessage());
        } catch (EventFactoryIsNotDefinedException $efinde) {
            throw new EventFactoryIsNotDefinedException('EventFactory should be defined for use case: '
                . $taggedServiceName . '. '
                . $efinde->getMessage());
        }
    }

    /**
     * @return Security
     */
    private function buildSecurity(array $tagParameters)
    {
        if (isset($tagParameters['security'])) {
            $security = $this->container->get($tagParameters['security']);
        } else {
            $defaultSecurityContextId = $this->container->getParameter(
                'openclassrooms.use_case.default_security_context'
            );
            if (!$this->container->has($defaultSecurityContextId)) {
                throw new SecurityIsNotDefinedException('Default security context: \'' . $defaultSecurityContextId . '\' is not defined.');
            }
            $security = $this->container->get(
                $this->container->getParameter('openclassrooms.use_case.default_security_context')
            );
        }
        if ($security instanceof SecurityContextInterface) {
            /** @var SecurityFactory $securityFactory */
            $securityFactory = $this->container->get('openclassrooms.use_case.security_factory');
            $security = $securityFactory->createSecurityContextSecurity($security);
        }

        return $security;
    }

    /**
     * @return Cache
     */
    private function buildCache(array $tagParameters)
    {
        if (isset ($tagParameters['cache'])) {
            /** @var Cache $cache */
            $cache = $this->container->get($tagParameters['cache']);
        } elseif ($this->container->has('openclassrooms.cache.cache')) {
            $cache = $this->container->get('openclassrooms.cache.cache');
        } else {
            throw new CacheIsNotDefinedException('Default cache is not defined. Have you configured openclassrooms_cache ?');
        }

        return $cache;
    }

    /**
     * @return Transaction
     */
    private function buildTransaction(array $tagParameters)
    {
        if (isset($tagParameters['transaction'])) {
            $transaction = $this->container->get($tagParameters['transaction']);
        } else {
            $defaultEntityManagerId = $this->container->getParameter('openclassrooms.use_case.default_entity_manager');
            if (!$this->container->has($defaultEntityManagerId)) {
                throw new TransactionIsNotDefinedException('Default entity manager: \'' . $defaultEntityManagerId . '\' is not defined.');
            }
            $transaction = $this->container->get(
                $this->container->getParameter('openclassrooms.use_case.default_entity_manager')
            );
        }
        if ($transaction instanceof ObjectManager) {
            /** @var TransactionFactory $transactionAdapterFactory */
            $transactionAdapterFactory = $this->container->get('openclassrooms.use_case.transaction_factory');
            $transaction = $transactionAdapterFactory->createEntityManagerTransaction($transaction);
        }

        return $transaction;
    }

    /**
     * @return EventSender
     */
    private function buildEvent(array $parameters)
    {
        if (isset($parameters['event-sender'])) {
            $event = $this->container->get($parameters['event-sender']);
        } else {
            $defaultEventId = $this->container->getParameter('openclassrooms.use_case.default_event_sender');
            if (!$this->container->has($defaultEventId)) {
                throw new EventIsNotDefinedException('Default EventSender: \'' . $defaultEventId . '\' is not defined.');
            }
            $event = $this->container->get($this->container->getParameter('openclassrooms.use_case.default_event_sender'));
        }
        if ($event instanceof EventDispatcherInterface) {
            $eventAdapterFactory = $this->container->get('openclassrooms.use_case.event_adapter_factory');
            $event = $eventAdapterFactory->createEventDispatcherEvent($event);
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
        } else {
            $defaultEventFactoryId = $this->container->getParameter('openclassrooms.use_case.default_event_factory');
            if (!$this->container->has($defaultEventFactoryId)) {
                throw new EventFactoryIsNotDefinedException('Default EventFactory: \'' . $defaultEventFactoryId . '\' is not defined.');
            }
            $eventFactory = $this->container->get($this->container->getParameter('openclassrooms.use_case.default_event_factory'));
        }

        return $eventFactory;
    }
}
