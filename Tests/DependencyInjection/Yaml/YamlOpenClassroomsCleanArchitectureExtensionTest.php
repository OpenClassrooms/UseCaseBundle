<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Yaml;

use
    OpenClassrooms\Bundle\CleanArchitectureBundle\DependencyInjection\OpenClassroomsCleanArchitectureExtension;
use OpenClassrooms\Bundle\CleanArchitectureBundle\OpenClassroomsCleanArchitectureBundle;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseRequestStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\TransactionUseCaseStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\UseCaseProxy;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class YamlOpenClassroomsCacheExtensionTest extends \PHPUnit_Framework_TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\CleanArchitecture\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl';

    /**
     * @var Extension
     */
    private $extension;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var YamlFileLoader
     */
    private $loader;

    /**
     * @test
     */
    public function GetUseCase()
    {
        $useCase = $this->container->get('openclassrooms.tests.use_cases.use_case_stub');
        $this->assertEquals(new UseCaseStub(), $useCase);
    }

    /**
     * @test
     */
    public function UseCaseTag_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.use_case_stub_tagged');

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new UseCaseStub(), $useCaseProxy->getUseCase());
    }

    /**
     * test
     */
    public function CacheUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.cache_use_case_stub');
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new CacheUseCaseStub(), $useCaseProxy->getUseCase());
    }

    /**
     * @test
     */
    public function TransactionUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.transaction_use_case_stub');
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new TransactionUseCaseStub(), $useCaseProxy->getUseCase());
    }

    protected function setUp()
    {
        $this->extension = new OpenClassroomsCleanArchitectureExtension();
        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
        $this->container->loadFromExtension('openclassrooms_clean_architecture');

        $loader = new XmlFileLoader($this->container, new FileLocator(__DIR__ . '/../Fixtures/Resources/config'));
        $loader->load('services.xml');

        $bundle = new OpenClassroomsCleanArchitectureBundle();
        $bundle->build($this->container);

//        $this->container->setParameter('openclassrooms.cache.cache_provider_builder.class', 'OpenClassrooms\Bundle\CacheBundle\Tests\Cache\CacheProviderBuilderMock');
        $this->loader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/Fixtures/Yaml/'));
        $this->container->compile();
    }
}
