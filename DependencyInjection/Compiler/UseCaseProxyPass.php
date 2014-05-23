<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyPass implements CompilerPassInterface
{
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
        $this->container = $container;
        $taggedServices = $this->container->findTaggedServiceIds('openclassrooms.use_case');
        if ($container->hasDefinition('annotation_reader')) {
            $reader = $container->get('annotation_reader');
        } else {
            $reader = new AnnotationReader();
        }
        $this->builder = $this->container->get(
            'openclassrooms.clean_architecture.use_case_proxy_builder'
        );
        foreach ($taggedServices as $taggedServiceName => $parameters) {
            $parameters = $parameters[0];
            /** @var UseCase $useCase */
            $useCase = $container->get($taggedServiceName);
            /** @var UseCaseProxyBuilder $builder */
            $this->builder
                ->create($useCase)
                ->withReader($reader)
                ->withTransaction($this->buildTransaction($parameters));
            $container->set($taggedServiceName, $this->builder->build());
        }
    }

    /**
     * @return mixed
     */
    protected function buildTransaction(array $parameters)
    {
        $transaction = null;
        if (isset($parameters['entity_manager'])) {
            $transactionAdapterFactory = $this->container->get(
                'openclassrooms.clean_architecture.transaction_factory'
            );
            $transaction = $transactionAdapterFactory->createEntityManagerTransaction(
                $this->container->get($parameters['entity_manager'])
            );

        }
        if (isset($parameters['transaction'])) {
            $transaction = $this->container->get($parameters['transaction']);
        }

        return $transaction;
    }

}
