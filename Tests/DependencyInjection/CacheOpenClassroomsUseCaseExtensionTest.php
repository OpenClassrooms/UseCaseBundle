<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTestCase;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTestCase
{
    /**
     * @test
     */
    public function WithCacheConfigurationWithoutCacheContext_CacheUseCase_ThrowException()
    {
        $this->expectException(CacheIsNotDefinedException::class);

        $this->configLoader->load('DefaultConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_cache_use_case_stub');
    }

    /**
     * @test
     */
    public function WithCacheConfiguration_CacheUseCase_ReturnUseCaseProxy()
    {
        $this->container = new ContainerBuilder();

        $this->initUseCaseBundle();
        $this->initServiceLoader();
        $this->initConfigLoader();
        $this->serviceLoader->load('cache_configuration_services.xml');
        $this->configLoader->load('CacheConfiguration.php');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_cache_use_case_stub');

        $this->assertUseCaseProxy($useCaseProxy);
    }

    protected function setUp(): void
    {
        $this->initContainer();
        $this->serviceLoader->load('cache_configuration_services.xml');
    }
}
