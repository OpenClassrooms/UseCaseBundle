<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTestCase;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTestCase
{
    /**
     * @test
     */
    public function WithSecurityConfigurationWithoutSecurityContext_SecurityUseCase_ThrowException()
    {
        $this->expectException(SecurityIsNotDefinedException::class);

        $this->configLoader->load('SecurityConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');
    }

    /**
     * @test
     */
    public function WithDefaultConfigurationWithoutSecurityContext_SecurityUseCase_ThrowException()
    {
        $this->expectException(SecurityIsNotDefinedException::class);

        $this->configLoader->load('DefaultConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');
    }

    /**
     * @test
     */
    public function WithSecurityConfiguration_SecurityUseCase_ReturnUseCaseProxy()
    {
        $this->configLoader->load('SecurityConfiguration.php');
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
        $this->configLoader->load('DefaultConfiguration.php');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_security_use_case_stub');

        $this->assertSecurityUseCaseProxy($useCaseProxy);
    }

    protected function setUp(): void
    {
        $this->initContainer();
        $this->serviceLoader->load('security_configuration_services.xml');
    }
}
