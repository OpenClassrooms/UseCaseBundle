<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTest;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTest
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException
     */
    public function WithEventConfigurationWithoutEvent_EventUseCase_ThrowException()
    {
        $this->configLoader->load('EventConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException
     * @expectedExceptionMessage EventSender should be defined for use case: OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\EventUseCaseStub. Default EventSender: 'event_dispatcher' is not defined.
     */
    public function WithDefaultConfigurationWithoutEvent_EventUseCase_ThrowException()
    {
        $this->configLoader->load('DefaultConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException
     */
    public function WithEventFactoryConfigurationWithoutEventFactory_EventUseCase_ThrowException()
    {
        $this->configLoader->load('EventConfiguration.yml');
        $this->serviceLoader->load('event_only_services.xml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');
    }

    /**
     * @test
     */
    public function WithEventConfiguration_EventUseCase_ReturnUseCaseProxy()
    {
        $this->configLoader->load('EventConfiguration.yml');
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
        $this->configLoader->load('DefaultConfiguration.yml');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_event_use_case_stub');

        $this->assertEventUseCaseProxy($useCaseProxy);
    }

    protected function setUp()
    {
        $this->initContainer();
        $this->serviceLoader->load('event_configuration_services.xml');
    }
}
