<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTest;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTest
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException
     */
    public function WithTransactionConfigurationWithoutTransaction_TransactionUseCase_ThrowException()
    {
        $this->configLoader->load('TransactionConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException
     * @expectedExceptionMessage Transaction should be defined for use case: openclassrooms.tests.use_cases.configuration_transaction_use_case_stub. Default entity manager: 'doctrine.orm.entity_manager' is not defined.
     */
    public function WithDefaultConfigurationWithoutTransaction_TransactionUseCase_ThrowException()
    {
        $this->configLoader->load('DefaultConfiguration.yml');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');
    }

    /**
     * @test
     */
    public function WithTransactionConfiguration_TransactionUseCase_ReturnUseCaseProxy()
    {
        $this->configLoader->load('TransactionConfiguration.yml');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');

        $this->assertTransactionUseCaseProxy($useCaseProxy);
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
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');

        $this->assertTransactionUseCaseProxy($useCaseProxy);
    }

    protected function setUp()
    {
        $this->initContainer();
        $this->serviceLoader->load('transaction_configuration_services.xml');
    }
}
