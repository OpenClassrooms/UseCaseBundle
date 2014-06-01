<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTest;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTest
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException
     */
    public function WithSecurityConfigurationWithoutSecurityContext_SecurityUseCase_ThrowException()
    {
        $this->configLoader->load('SecurityConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException
     */
    public function WithDefaultConfigurationWithoutSecurityContext_SecurityUseCase_ThrowException()
    {
        $this->configLoader->load('DefaultConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');
    }

    /**
     * @test
     */
    public function WithSecurityConfiguration_SecurityUseCase_ReturnUseCaseProxy()
    {
        $this->configLoader->load('SecurityConfiguration.yml');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');

        $this->assertSecurityUseCaseProxy($useCaseProxy);
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
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');

        $this->assertSecurityUseCaseProxy($useCaseProxy);
    }

    protected function setUp()
    {
        $this->initContainer();
        $this->serviceLoader->load('security_configuration_services.xml');
    }
}
