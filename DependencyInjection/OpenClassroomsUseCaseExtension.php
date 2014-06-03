<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsUseCaseExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/'));
        $loader->load('services.xml');

        $config = $this->processConfiguration(new Configuration(), $config);

        $container->setParameter('openclassrooms.use_case.default_security_context',$config['security']);
        $container->setParameter('openclassrooms.use_case.default_entity_manager',$config['transaction']);
        $container->setParameter('openclassrooms.use_case.default_event_sender',$config['event_sender']);
        $container->setParameter('openclassrooms.use_case.default_event_factory',$config['event_factory']);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'openclassrooms_use_case';
    }
}
