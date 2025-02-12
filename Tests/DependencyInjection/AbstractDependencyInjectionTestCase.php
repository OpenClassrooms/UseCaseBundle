<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection;

use OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection\OpenClassroomsUseCaseExtension;
use OpenClassrooms\Bundle\UseCaseBundle\OpenClassroomsUseCaseBundle;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\CacheUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseRequestStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseResponseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\EventUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\SecurityUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\TransactionUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\CacheSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\ConnectionMock;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\EventDispatcherSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\AuthorizationCheckerSpy;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class AbstractDependencyInjectionTestCase extends TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyImpl';

    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var PhpFileLoader
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
        $this->container->loadFromExtension('open_classrooms_use_case');
        $bundle = new OpenClassroomsUseCaseBundle();
        $bundle->build($this->container);
    }

    protected function initServiceLoader()
    {
        $this->serviceLoader = new XmlFileLoader($this->container, new FileLocator(__DIR__.'/Fixtures/Resources/config'));
        $this->serviceLoader->load('services.xml');
    }

    protected function initConfigLoader()
    {
        $this->configLoader = new PhpFileLoader($this->container, new FileLocator(__DIR__.'/Fixtures/Resources/config/'));
        $this->configLoader->load('DefaultConfiguration.php');
    }

    protected function assertSecurityUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new SecurityUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(AuthorizationCheckerSpy::$isGranted);
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
        $this->assertNotEmpty(CacheSpy::$saved);
    }

    protected function assertTransactionUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new TransactionUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(ConnectionMock::$committed);
    }

    protected function assertEventUseCaseProxy(UseCaseProxy $useCaseProxy)
    {
        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new EventUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(EventDispatcherSpy::$sent);
        $this->assertEquals(EventUseCaseStub::EVENT_NAME, EventDispatcherSpy::$eventName);
    }
}
