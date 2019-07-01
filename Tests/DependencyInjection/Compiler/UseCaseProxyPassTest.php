<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Compiler;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTest;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\EventUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\SecurityUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\TransactionUseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\EventSenderSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\PDOTransactionSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\SecuritySpy;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseProxyPassTest extends AbstractDependencyInjectionTest
{
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
    public function WithoutExistingReaderGetUseCaseTagged_ReturnProxy()
    {
        $this->container = new ContainerBuilder();

        $this->initUseCaseBundle();
        $this->initServiceLoader();
        $this->initConfigLoader();
        $this->container->removeDefinition('annotation_reader');
        $this->container->compile();

        $useCase = $this->container->get('openclassrooms.tests.use_cases.use_case_stub');

        $this->assertEquals(new UseCaseStub(), $useCase);
    }

    /**
     * @test
     */
    public function UseCaseTagged_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.use_case_stub_tagged');

        $this->assertUseCaseProxy($useCaseProxy);
    }

    /**
     * @test
     */
    public function SecurityUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.security_use_case_stub');

        $this->assertUseCaseProxy($useCaseProxy);

        $this->assertEquals(new SecurityUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(SecuritySpy::$checked);
    }

    /**
     * @test
     */
    public function SecurityAuthorizationCheckerUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get(
            'openclassrooms.tests.use_cases.security_authorization_checker_use_case_stub'
        );

        $this->assertSecurityUseCaseProxy($useCaseProxy);
    }

    /**
     * @test
     */
    public function CacheUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.cache_use_case_stub');

        $this->assertCacheUseCaseProxy($useCaseProxy);
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

        $this->assertTransactionUseCaseProxy($useCaseProxy);
    }

    /**
     * @test
     */
    public function WithTransactionTransactionUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.transaction_transaction_use_case_stub');

        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new TransactionUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(PDOTransactionSpy::$committed);
    }

    /**
     * @test
     */
    public function EventUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.event_event_use_case_stub');

        $this->assertUseCaseProxy($useCaseProxy);
        $this->assertEquals(new EventUseCaseStub(), $useCaseProxy->getUseCase());
        $this->assertTrue(EventSenderSpy::$sent);
        $this->assertEquals(EventUseCaseStub::EVENT_NAME, EventSenderSpy::$eventName);
    }

    /**
     * @test
     */
    public function WithEventDispatcherEventUseCase_ReturnProxy()
    {
        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.event_dispatcher_event_use_case_stub');

        $this->assertEventUseCaseProxy($useCaseProxy);
    }

    protected function setUp()
    {
        $this->initContainer();
        $this->container->compile();
    }
}
