<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseProxyPass implements CompilerPassInterface
{
    /**
     * @var ContainerBuilder
     */
    private $container;

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
        $this->buildReader();
        $this->buildUseCaseProxies();
    }

    private function buildReader()
    {
        if (!$this->container->hasDefinition('annotation_reader')) {
            $readerDefinition = new Definition();
            $readerDefinition->setClass(get_class(new AnnotationReader()));
            $this->container->setDefinition('annotation_reader', $readerDefinition);
        }
    }

    private function buildUseCaseProxies()
    {
        $taggedServices = $this->container->findTaggedServiceIds('openclassrooms.use_case');

        foreach ($taggedServices as $taggedServiceName => $tagParameters) {
            $this->buildUseCaseProxyFactoryDefinition($taggedServiceName, $tagParameters);
        }
    }

    private function buildUseCaseProxyFactoryDefinition($taggedServiceName, $tagParameters)
    {
        $definition = $this->container->findDefinition($taggedServiceName);
        $factoryDefinition = new Definition();
        $factoryDefinition->setFactory([
            new Reference('openclassrooms.use_case.use_case_proxy_factory'),
            'create'
        ]);
        $factoryDefinition->setArguments(array($definition, $tagParameters[0]));
        $this->container->setDefinition($taggedServiceName, $factoryDefinition);
    }
}
