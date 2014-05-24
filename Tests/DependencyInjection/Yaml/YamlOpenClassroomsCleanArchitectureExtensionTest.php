<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Yaml;

use
    OpenClassrooms\Bundle\CleanArchitectureBundle\DependencyInjection\OpenClassroomsCleanArchitectureExtension;
use OpenClassrooms\Bundle\CleanArchitectureBundle\OpenClassroomsCleanArchitectureBundle;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\CacheUseCaseStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseRequestStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\EventUseCaseStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\SecurityUseCaseStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\TransactionUseCaseStub;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\CacheSpy;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\EntityManagerSpy;
use OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\EventSpy;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\PDOTransactionSpy;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\SecurityContextSpy;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\SecuritySpy;
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
    public function UseCaseTagged_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.use_case_stub_tagged'
        );

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new UseCaseStub(), $useCaseProxy->getUseCase());
    }

    /**
     * @test
     */
    public function WithoutExistingReaderGetUseCaseTagged_ReturnProxy()
    {
        $this->initContainer();
        $this->container->removeDefinition('annotation_reader');
        $this->container->compile();
        $useCase = $this->container->get('openclassrooms.tests.use_cases.use_case_stub');
        $this->assertEquals(new UseCaseStub(), $useCase);
    }

    private function initContainer()
    {
        $this->extension = new OpenClassroomsCleanArchitectureExtension();
        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
        $this->container->loadFromExtension('openclassrooms_clean_architecture');

        $loader = new XmlFileLoader($this->container, new FileLocator(__DIR__ . '/../Fixtures/Resources/config'));
        $loader->load('services.xml');

        $bundle = new OpenClassroomsCleanArchitectureBundle();
        $bundle->build($this->container);

        $this->loader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/Fixtures/Yaml/'));
    }

    /**
     * @test
     */
    public function SecurityUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.security_use_case_stub'
        );
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new SecurityUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(SecuritySpy::$checked);
    }

    /**
     * @test
     */
    public function SecurityContextSecurityUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.security_context_security_use_case_stub'
        );
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new SecurityUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(SecurityContextSpy::$isGranted);
    }

    /**
     * @test
     */
    public function CacheUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.cache_use_case_stub');
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new CacheUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(CacheSpy::$saved);
    }

    /**
     * @test
     */
    public function WithEntityManagerTransactionUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.entity_manager_transaction_use_case_stub'
        );
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new TransactionUseCaseStub(), $useCaseProxy->getUseCase());
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue(EntityManagerSpy::$committed);
    }

    /**
     * @test
     */
    public function WithTransactionTransactionUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.transaction_transaction_use_case_stub'
        );
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new TransactionUseCaseStub(), $useCaseProxy->getUseCase());
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue(PDOTransactionSpy::$committed);
    }

    /**
     * @test
     */
    public function EventUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.event_event_use_case_stub'
        );
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new EventUseCaseStub(), $useCaseProxy->getUseCase());
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue(EventSpy::$sent);
    }

    /**
     * @test
     */
    public function WithEventDispatcherEventUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.event_dispatcher_event_use_case_stub'
        );
        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $useCaseProxy);
        $this->assertEquals(new EventUseCaseStub(), $useCaseProxy->getUseCase());
        $useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertTrue(EventSpy::$sent);
    }


    protected function setUp()
    {
        $this->initContainer();

        $this->container->compile();
    }
}
