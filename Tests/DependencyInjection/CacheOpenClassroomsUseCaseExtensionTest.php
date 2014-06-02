<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTest;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTest
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException
     */
    public function WithCacheConfigurationWithoutCacheContext_CacheUseCase_ThrowException()
    {
        $this->configLoader->load('DefaultConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_cache_use_case_stub');
    }

    /**
     * @test
     */
    public function WithCacheConfiguration_CacheUseCase_ReturnUseCaseProxy()
    {
        $this->container = new ContainerBuilder();

        $this->initCacheBundle();
        $this->initUseCaseBundle();
        $this->initServiceLoader();
        $this->initConfigLoader();
        $this->serviceLoader->load('cache_configuration_services.xml');
        $this->configLoader->load('CacheConfiguration.yml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_cache_use_case_stub');

        $this->assertUseCaseProxy($useCaseProxy);
    }

    protected function setUp()
    {
        $this->initContainer();
        $this->serviceLoader->load('cache_configuration_services.xml');
    }
}
