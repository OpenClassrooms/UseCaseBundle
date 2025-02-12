<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Proxy\Impl;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Persistence\ObjectManager;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Proxy\UseCaseProxyFactory;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\SecurityFactory;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\TransactionFactory;
use OpenClassrooms\Cache\Cache\Cache;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\Application\Services\Security\Security;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use OpenClassrooms\UseCase\Application\Annotations\Security as SecurityAnnotation;
use OpenClassrooms\UseCase\Application\Annotations\Cache as CacheAnnotation;
use OpenClassrooms\UseCase\Application\Annotations\Transaction as TransactionAnnotation;
use OpenClassrooms\UseCase\Application\Annotations\Event as EventAnnotation;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseProxyFactoryImpl implements UseCaseProxyFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    public function __construct()
    {
        $this->builder = new UseCaseProxyBuilderImpl();
    }

    public function create(UseCase $useCase, $tagParameters)
    {
        try {
            /** @var UseCase $useCase */
            $methodAnnotations = $this->reader->getMethodAnnotations(new \ReflectionMethod($useCase, 'execute'));

            /** @var UseCaseProxyBuilder $builder */
            $this->builder
                ->create($useCase)
                ->withReader($this->reader);

            foreach ($methodAnnotations as $annotation) {
                if ($annotation instanceof SecurityAnnotation) {
                    $this->builder->withSecurity($this->buildSecurity($tagParameters));
                }
                if ($annotation instanceof CacheAnnotation) {
                    $this->builder->withCache($this->buildCache($tagParameters));
                }
                if ($annotation instanceof TransactionAnnotation) {
                    $this->builder->withTransaction($this->buildTransaction($tagParameters));
                }
                if ($annotation instanceof EventAnnotation) {
                    $this->builder
                        ->withEventSender($this->buildEvent($tagParameters))
                        ->withEventFactory($this->buildEventFactory($tagParameters));
                }
            }

            return $this->builder->build();
        } catch (SecurityIsNotDefinedException $sinde) {
            throw new SecurityIsNotDefinedException(
                'Security should be defined for use case: '
                .get_class($useCase).'. '
                .$sinde->getMessage());
        } catch (CacheIsNotDefinedException $cinde) {
            throw new CacheIsNotDefinedException('Cache should be defined for use case: '
                .get_class($useCase).'. '
                .$cinde->getMessage());
        } catch (TransactionIsNotDefinedException $tinde) {
            throw new TransactionIsNotDefinedException('Transaction should be defined for use case: '
                .get_class($useCase).'. '
                .$tinde->getMessage());
        } catch (EventIsNotDefinedException $einde) {
            throw new EventIsNotDefinedException('EventSender should be defined for use case: '
                .get_class($useCase).'. '
                .$einde->getMessage());
        } catch (EventFactoryIsNotDefinedException $efinde) {
            throw new EventFactoryIsNotDefinedException('EventFactory should be defined for use case: '
                .get_class($useCase).'. '
                .$efinde->getMessage());
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
                'openclassrooms.use_case.default_authorization_checker'
            );
            if (!$this->container->has($defaultSecurityContextId)) {
                throw new SecurityIsNotDefinedException('Default security context: \''.$defaultSecurityContextId.'\' is not defined.');
            }
            $security = $this->container->get(
                $this->container->getParameter('openclassrooms.use_case.default_authorization_checker')
            );
        }
        if ($security instanceof AuthorizationCheckerInterface) {
            /** @var SecurityFactory $securityFactory */
            $securityFactory = $this->container->get('openclassrooms.use_case.security_factory');
            $security = $securityFactory->createAuthorizationCheckerSecurity($security);
        }

        return $security;
    }

    /**
     * @return Cache
     */
    private function buildCache(array $tagParameters)
    {
        if (isset($tagParameters['cache'])) {
            /** @var Cache $cache */
            $cache = $this->container->get($tagParameters['cache']);
        } elseif ($this->container->has('openclassrooms.use_case.cache')) {
            $cache = $this->container->get('openclassrooms.use_case.cache');
        } else {
            throw new CacheIsNotDefinedException('Default cache is not defined. Have you configured it ?');
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
                throw new TransactionIsNotDefinedException('Default entity manager: \''.$defaultEntityManagerId.'\' is not defined.');
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
                throw new EventIsNotDefinedException('Default EventSender: \''.$defaultEventId.'\' is not defined.');
            }
            $event = $this->container->get(
                $this->container->getParameter('openclassrooms.use_case.default_event_sender')
            );
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
                throw new EventFactoryIsNotDefinedException('Default EventFactory: \''.$defaultEventFactoryId.'\' is not defined.');
            }
            $eventFactory = $this->container->get(
                $this->container->getParameter('openclassrooms.use_case.default_event_factory')
            );
        }

        return $eventFactory;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }
}
