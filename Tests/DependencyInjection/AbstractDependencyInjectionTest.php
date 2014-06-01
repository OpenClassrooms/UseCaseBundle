<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection;

use OpenClassrooms\Bundle\CacheBundle\DependencyInjection\OpenClassroomsCacheExtension;
use OpenClassrooms\Bundle\CacheBundle\OpenClassroomsCacheBundle;
use OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection\OpenClassroomsUseCaseExtension;
use OpenClassrooms\Bundle\UseCaseBundle\OpenClassroomsUseCaseBundle;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\CacheUseCaseStub;
use
    OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseRequestStub;
use
    OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseResponseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\SecurityUseCaseStub;
use
    OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\TransactionUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\CacheSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\EntityManagerSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\SecurityContextSpy;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class AbstractDependencyInjectionTest extends \PHPUnit_Framework_TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl';

    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var YamlFileLoader
     */
    protected $configLoader;

    /**
     * @var XmlFileLoader
     */
    protected $serviceLoader;

    protected function initContainer()
    {
        $this->container = new ContainerBuilder();

        $this->initUseCaseBundle();
        $this->initServiceLoader();
        $this->initConfigLoader();
    }

    protected function initUseCaseBundle()
    {
        $useCaseExtension = new OpenClassroomsUseCaseExtension();
        $this->container->registerExtension($useCaseExtension);
        $this->container->loadFromExtension('openclassrooms_use_case');
        $bundle = new OpenClassroomsUseCaseBundle();
        $bundle->build($this->container);
    }

    protected function initServiceLoader()
    {
        $this->serviceLoader = new XmlFileLoader($this->container, new FileLocator(__DIR__ . '/Fixtures/Resources/config'));
        $this->serviceLoader->load('services.xml');
    }

    protected function initConfigLoader()
    {
        $this->configLoader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/Fixtures/Resources/config/'));
        $this->configLoader->load('DefaultConfiguration.yml');
    }

    protected function assertSecurityUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new SecurityUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(SecurityContextSpy::$isGranted);
    }

    protected function assertUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $useCaseResponse = $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $useCaseResponse);
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
    }

    protected function assertCacheUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new CacheUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(CacheSpy::$saved);
    }

    protected function assertTransactionUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new TransactionUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(EntityManagerSpy::$committed);
    }

    protected function initCacheBundle()
    {
        $cacheExtension = new OpenClassroomsCacheExtension();
        $this->container->registerExtension($cacheExtension);
        $this->container->loadFromExtension('openclassrooms_cache');

        $cacheBundle = new OpenClassroomsCacheBundle();
        $cacheBundle->build($this->container);
    }
}
