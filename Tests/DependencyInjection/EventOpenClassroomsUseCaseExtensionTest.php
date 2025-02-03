<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTestCase;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTestCase
{
    /**
     * @test
     */
    public function WithEventConfigurationWithoutEvent_EventUseCase_ThrowException()
    {
        $this->expectException(EventIsNotDefinedException::class);

        $this->configLoader->load('EventConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');
    }

    /**
     * @test
     */
    public function WithDefaultConfigurationWithoutEvent_EventUseCase_ThrowException()
    {
        $this->expectException(EventIsNotDefinedException::class);
        $this->expectExceptionMessage("EventSender should be defined for use case: OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\EventUseCaseStub. Default EventSender: 'event_dispatcher' is not defined.");

        $this->configLoader->load('DefaultConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');
    }

    /**
     * @test
     */
    public function WithEventFactoryConfigurationWithoutEventFactory_EventUseCase_ThrowException()
    {
        $this->expectException(EventFactoryIsNotDefinedException::class);

        $this->configLoader->load('EventConfiguration.php');
        $this->serviceLoader->load('event_only_services.xml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');
    }

    /**
     * @test
     */
    public function WithEventConfiguration_EventUseCase_ReturnUseCaseProxy()
    {
        $this->configLoader->load('EventConfiguration.php');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');

        $this->assertEventUseCaseProxy($useCaseProxy);
    }

    /**
     * @test
     */
    public function WithDefaultConfiguration_ReturnUseCaseProxy()
    {
        $this->configLoader->load('DefaultConfiguration.php');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');

        $this->assertEventUseCaseProxy($useCaseProxy);
    }

    protected function setUp(): void
    {
        $this->initContainer();
        $this->serviceLoader->load('event_configuration_services.xml');
    }
}
